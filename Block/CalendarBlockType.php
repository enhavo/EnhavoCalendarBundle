<?php

namespace Enhavo\Bundle\CalendarBundle\Block;

use Doctrine\ORM\EntityRepository;
use Enhavo\Bundle\BlockBundle\Model\BlockInterface;
use Enhavo\Bundle\CalendarBundle\Entity\CalendarBlock;
use Enhavo\Bundle\CalendarBundle\Factory\CalendarBlockFactory;
use Enhavo\Bundle\CalendarBundle\Form\Type\CalendarBlockType as CalendarBlockFormType;
use Enhavo\Bundle\BlockBundle\Block\AbstractBlockType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarBlockType extends AbstractBlockType
{
    /** @var EntityRepository */
    private $repository;

    /**
     * CalendarBlockType constructor.
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createViewData(BlockInterface $block, $resource, array $options)
    {
        $data = parent::createViewData($block, $resource, $options);
        $data['appointments'] = $this->repository->findAll();
        return $data;
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'model' => CalendarBlock::class,
            'form' => CalendarBlockFormType::class,
            'factory' => CalendarBlockFactory::class,
            'template' => 'theme/block/calendar.html.twig',
            'label' => 'Calendar',
            'translation_domain' => 'EnhavoCalendarBundle',
            'groups' => ['default', 'content']
        ]);
    }

    public static function getName(): ?string
    {
        return 'calendar';
    }
}
