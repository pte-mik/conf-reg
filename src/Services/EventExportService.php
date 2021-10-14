<?php namespace Application\Services;


use Application\Entity\Event;
use Application\Entity\Submission;
use Application\Entity\User;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Core\PathResolverInterface;
use Twig\Loader\FilesystemLoader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EventExportService {

	public function __construct(private PathResolverInterface $pathResolver) { }

	public function exportUsers(Event $event){
		$submissions = Submission::search(Filter::where(Submission::eventId($event->id))->and(Submission::status(Submission::status__accepted)))->collect();
		$users = [];
		foreach ($submissions as $submission){
			$users[$submission->userId] = $submission->user;
		}

		usort($users, function(User $a, User $b){
			return strcmp($a->name, $b->name);
		});

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$index = 1;
		foreach ($users as $user){
			$sheet->setCellValue('A'.$index, $user->name);
			$sheet->setCellValue('B'.$index, $user->email);
			$index++;
		}
		$writer = new Xlsx($spreadsheet);
		$folder = $this->pathResolver->path('var/tmp/export');
		$file = $folder.'/users-'.time().'.xlsx';
		$writer->save($file);
		register_shutdown_function(fn()=>unlink($file));
		return $file;
	}

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
			mkdir($folder.'/'.$submission->category, 0777, true);
			file_put_contents($folder.'/'.$submission->category.'/'.$submission->id.'.txt', $output);
			if($submission->image->count){
				$source = $submission->image->first->file->getRealPath();
				$target = $folder.'/'.$submission->category.'/'.$submission->id.'.'.$data['image']['ext'];
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
