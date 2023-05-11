<?php

namespace App\Command;

use App\Entity\Crm\Admin;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateAdminCommand extends Command
{
    private $container;

    public function __construct($name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setName('admin:create')
            ->setDescription('Just create admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');

        $emailQuestion = new Question('Enter email: ');
        $passwordQuestion = new Question('Enter password: ');
        $passwordVerifyQuestion = new Question('Retype password: ');
        $roleQuestion = new ChoiceQuestion(
            'Select role (default is ROLE_USER)',
            [Admin::ROLE_REDACTOR, Admin::ROLE_MODERATOR, Admin::ROLE_ADMIN],
            0
        );
        $roleQuestion->setErrorMessage('Role %s is invalid.');

        $passwordQuestion->setHidden(true);
        $passwordVerifyQuestion->setHidden(true);

        $email = $questionHelper->ask($input, $output, $emailQuestion);
        $password = $questionHelper->ask($input, $output, $passwordQuestion);
        $passwordVerify = $questionHelper->ask($input, $output, $passwordVerifyQuestion);
        $role = $questionHelper->ask($input, $output, $roleQuestion);


        if ($email && $password && $passwordVerify && $password == $passwordVerify) {
            $encoder = $this->container->get('security.password_encoder');
            $em = $this->container->get('doctrine')->getManager();

            $admin = new Admin();
            $admin->setEmail($email);
            $admin->setEnabled(true);
            $admin->addRole($role);
            $admin->setPassword($encoder->encodePassword($admin, $password));

            $em->persist($admin);
            $em->flush();

            $output->writeln('User created');
        }
        return 1;
    }

}
