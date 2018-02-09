<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MessagesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'required' => true
            ))
            ->add('email', EmailType::class, array(
                'required' => true
            ))
            ->add('homepage',null,  array(
                'required' => false
            ))
            ->add('message', null, array(
                'required' => true
            ))
            ->add('date')
            ->add('userip', HiddenType::class, array(
                'data' => $options['userip']
            ))
            ->add('browser', HiddenType::class, array(
                'data' => $options['browser']
            ))
            ->add('image', FileType::class, array(
                'data_class' => null,
                'required' => false
            ))
            ->add('textfile', FileType::class, array(
                'data_class' => null,
                'required' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Messages',
            'userip' => null,
            'browser' => null,
            'textfile' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_messages';
    }


}
