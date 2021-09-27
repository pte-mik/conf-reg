<?php namespace Application\Missions\Cli;

use Application\Entity\Event;
use Application\Entity\Submission;
use Application\Services\EventExportService;
use Atomino\Core\ApplicationConfig;
use Atomino\Core\Cli\Attributes\Command;
use Atomino\Core\Cli\CliCommand;
use Atomino\Core\Cli\CliModule;
use Atomino\Core\Cli\CliTree;
use Atomino\Core\Cli\Style;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;
use Twig\Extension\StringLoaderExtension;
use Twig\Lexer;
use Twig\Loader\FilesystemLoader;
use function Atomino\debug;

class Common extends CliModule {

	public function __construct(private ApplicationConfig $config, private EventExportService $eventExportService) { }

	#[Command("show-config", "cfg", "Shows the config")]
	public function showConfig(CliCommand $command) {
		$command->define(function (Input $input, Output $output, Style $style) {
			echo CliTree::draw($this->config->all(), 'cfg');
		});
	}

	#[Command("export", null, "Exports template")]
	public function exprot(CliCommand $command) {
		$command->define(function (Input $input, Output $output, Style $style) {
			$event = Event::pick(1);

			$this->eventExportService->export($event);

//			$submission = Submission::pick(14);
//
//			$template = $event->abstractTemplate;
//			$twig = new \Twig\Environment(new FilesystemLoader());
//			$twig->addExtension(new \Twig\Extension\StringLoaderExtension());
//
//			echo $twig->createTemplate($template)->render($submission->getTemplateData());
		});
	}
}
