<?php
/**
 * Copyright Zikula Foundation 2016 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Zikula\BlocksModule\Block\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class XsltBlockType
 * @package Zikula\BlocksModule\Block\Form\Type
 */
class XsltBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('docurl', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'constraints' => [
                    new Url()
                ],
                'required' => false,
                'label' => __('Document URL')
            ])
            ->add('doccontents', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', [
                'label' => __('Document contents'),
                'required' => false,
                'attr' => [
                    'rows' => 15
                ]
            ])
            ->add('styleurl', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'constraints' => [
                    new Url()
                ],
                'required' => false,
                'label' => __('Style sheet URL')
            ])
            ->add('stylecontents', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', [
                'label' => __('Style sheet contents'),
                'required' => false,
                'attr' => [
                    'rows' => 15
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // add a constraint to the entire form
        $resolver->setDefaults([
            'constraints' => new Callback(['callback' => [$this, 'validateOrFields']]),
        ]);
    }

    public function getName()
    {
        return 'zikulablocksmodule_xsltblock';
    }

    /**
     * Validation method for entire form.
     *
     * @param $data
     * @param ExecutionContextInterface $context
     */
    public function validateOrFields($data, ExecutionContextInterface $context)
    {
        if (empty($data['docurl']) && empty($data['doccontents'])) {
            $context->addViolation(__('Either the Document URL or the Document contents must contain a value.'));
        }
        if (!empty($data['docurl']) && !empty($data['doccontents'])) {
            $context->addViolation(__('Either the Document URL of the Document contents can contain a value, not both.'));
        }
        if (empty($data['styleurl']) && empty($data['stylecontents'])) {
            $context->addViolation(__('Either the Style sheet URL or the Style sheet contents must contain a value.'));
        }
        if (!empty($data['styleurl']) && !empty($data['stylecontents'])) {
            $context->addViolation(__('Either the Style sheet URL or the Style sheet contents can contain a value, not both.'));
        }
    }
}
