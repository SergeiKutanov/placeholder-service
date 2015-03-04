<?php
/**
 * Created by PhpStorm.
 * User: sergei
 * Date: 22.02.15
 * Time: 20:21
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PlaceholderType extends AbstractType{

    public function buildForm(FormBuilderInterface $builderInterface, array $options)
    {
        $builderInterface
            ->add(
                'text',
                'text',
                array(
                    'required'  => false,
                    'label_attr'=> array(
                        'class'         => 'control-label col-sm-2'
                    )
                )
            )
            ->add(
                'width',
                'integer',
                array(
                    'required'  => false,
                    'attr'      => array(
                        'class'         => 'form-control'
                    ),
                    'data'      => 300,
                    'label_attr'=> array(
                        'class'         => 'control-label col-sm-2'
                    )
                )
            )
            ->add(
                'height',
                'integer',
                array(
                    'required'  => false,
                    'attr'      => array(
                        'class'         => 'form-control'
                    ),
                    'data'      => 300,
                    'label_attr'=> array(
                        'class'         => 'control-label col-sm-2'
                    )
                )
            )
            ->add(
                'bgcolor',
                'text',
                array(
                    'required'  => false,
                    'attr'      => array(
                        'class'         => 'form-control'
                    ),
                    'data'      => '#FFFFFF',
                    'label_attr'=> array(
                        'class'         => 'control-label col-sm-2'
                    )
                )
            )
            ->add(
                'fontcolor',
                'text',
                array(
                    'required'  => false,
                    'attr'      => array(
                        'class'         => 'form-control'
                    ),
                    'data'      => '#555555',
                    'label_attr'=> array(
                        'class'         => 'control-label col-sm-2'
                    )
                )
            )
            ->add(
                'fontsize',
                'integer',
                array(
                    'required'  => false,
                    'attr'      => array(
                        'class'         => 'form-control'
                    ),
                    'data'      => '14',
                    'label_attr'=> array(
                        'class'         => 'control-label col-sm-2'
                    )
                )
            );
    }

    public function getName()
    {
        return 'placeholder';
    }

}