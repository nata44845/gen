<?php

namespace App\Form\Type\Crm;

use App\Entity\Crm\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'e-mail',
                'required' => true
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Разрешен',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Роли (права доступа)',
                'choices' => [
                    'администратор' => Admin::ROLE_ADMIN,
                    'модератор' => Admin::ROLE_MODERATOR,
                    'редактор' => Admin::ROLE_REDACTOR
                ],
                'multiple'  => true,
                'expanded' => true,
                'required' => true
            ])
            // ->add('roles', CollectionType::class, [
            //     'label' => 'Роль (права доступа)',
            //     'entry_type'   => ChoiceType::class,
            //     'entry_options'  => [
            //         'label' => '',
            //         'choices' => [
            //             'администратор' => Admin::ROLE_ADMIN,
            //             'модератор' => Admin::ROLE_MODERATOR,
            //             'редактор' => Admin::ROLE_REDACTOR
            //         ]],
            //     'required' => true
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
             'data_class' => Admin::class
        ]);
    }
}
