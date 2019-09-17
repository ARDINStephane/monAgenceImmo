<?php

namespace App\Listener;

use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{
    /**
     * @var CacheManager
     */
    private $cacheManager;
    /**
     * @var UploaderHelper
     */
    private $helper;

    public function __construct(
        CacheManager $cacheManager,
        UploaderHelper $helper
    ) {
        $this->cacheManager = $cacheManager;
        $this->helper = $helper;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if(!$entity instanceof Property) {
            return;
        }
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();

        if(!$entity instanceof Property) {
            return;
        }
        $this->cacheManager->remove($this->helper->asset($entity, 'imageFile'));


        if($entity instanceof UploadedFile) {
            $this->cacheManager->remove($this->helper->asset($entity, 'imageFile'));
        }
    }
}