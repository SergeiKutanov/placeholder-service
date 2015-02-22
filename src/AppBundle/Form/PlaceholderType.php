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
                    'label'     => 'Text',
                    'attr'      => array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Enter text to be printed on the image (default value - empty)'
                    ),
                    'data'      => 'Some Text',
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
                    'label'     => 'Width (px)',
                    'attr'      => array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Enter width for your image (default value - 300)'
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
                    'label'     => 'Height (px)',
                    'attr'      => array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Enter height for your image (default value - 300)'
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
                    'label'     => 'Backrgound Color (HEX)',
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
                    'label'     => 'Font Color (HEX)',
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
                    'label'     => 'Font Size (px)',
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