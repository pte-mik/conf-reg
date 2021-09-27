<?php namespace Application\Services;


use Application\Entity\Event;
use Application\Entity\Submission;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Core\PathResolverInterface;
use Twig\Loader\FilesystemLoader;

class EventExportService {

	public function __construct(private PathResolverInterface $pathResolver) { }

	public function export(Event $event):string{
		$folder = $this->pathResolver->path('var/tmp/export').'/'.time();
		mkdir($folder, 0777, true);
		$twig = new \Twig\Environment(new FilesystemLoader());
		$twig->addExtension(new \Twig\Extension\StringLoaderExtension());

		$template = $twig->createTemplate($event->abstractTemplate);

		$submissions = Submission::search(Filter::where(Submission::eventId($event->id))->and(Submission::status(Submission::status__accepted)))->collect();
		foreach ($submissions as $submission){
			$data = $submission->getTemplateData();
			$output = $template->render($data);
			file_put_contents($folder.'/'.$submission->id.'.txt', $output);
			if($submission->image->count){
				$source = $submission->image->first->file->getRealPath();
				$target = $folder.'/'.$submission->id.'.'.$data['image']['ext'];
				copy($source, $target);
			}
		}

		$zip = $folder.'.zip';
		chdir($folder);
		exec('zip -r '.$zip.' ./');
		array_map('unlink', glob($folder."/*.*"));
		rmdir($folder);
		register_shutdown_function(fn()=>unlink($zip));
		return $zip;
	}


}
