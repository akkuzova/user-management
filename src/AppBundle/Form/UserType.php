<?php

namespace AppBundle\Form;

use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function getName()
    {
        return 'user';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'csrf_protection' => false,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groupTransformer = new EntityToIdObjectTransformer($this->om, Group::class);

        $builder
            ->add('id', IntegerType::class, ['mapped' => false])
            ->add('email', EmailType::class, ['constraints' => [new Email()]])
            ->add('first_name', TextType::class, ['constraints' => [new NotBlank()]])
            ->add('last_name', TextType::class, ['constraints' => [new NotBlank()]])
            ->add('creation_date', TextType::class, ['mapped' => false])
            ->add('state', ChoiceType::class, [
                    'choices' => [
                        1 => User::ACTIVE,
                        2 => User::NON_ACTIVE
                    ],
                    'constraints' => [new NotBlank()]
                ]
            )
            ->add($builder->create('group', TextType::class)->addModelTransformer($groupTransformer));
    }
}