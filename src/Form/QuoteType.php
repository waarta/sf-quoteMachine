<?php
namespace App\Form;

use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, ['label' => 'Citation'])
            ->add('meta', TextareaType::class, ['label' => 'Meta'])
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'required' => false,
                'placeholder' => "",
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.libCatg', 'ASC');
                },
                'choice_label' => 'libCatg'))
            ->add('save', SubmitType::class);

    }
}
