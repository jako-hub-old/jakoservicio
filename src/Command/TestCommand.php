<?php
namespace App\Command;

use App\Classes\Utilidades;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Clase de comandos para realizar pruebas.
 * Class TestCommand
 * @package App\Command
 */
class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName("app:test:traduccion")
            ->setDescription("Prueba de traducción de textos.")
            ->setHelp("Prueba");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('68f3f797', 'ZwXadzBwzVmV1mBa');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '573205015059',
            'from' => 'Nexmo',
            'text' => 'Hello from Nexmo'
        ]);
//        echo "Traducción\n";
//        echo Utilidades::t('validacion_1') . "\n";
//        echo Utilidades::validacion('1') . "\n";
//        echo Utilidades::t('error_1') . "\n";
//        echo Utilidades::error('1') . "\n";
//        exit();
    }

}