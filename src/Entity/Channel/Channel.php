<?php

declare(strict_types=1);

namespace App\Entity\Channel;

use Dedi\SyliusSEOPlugin\Domain\SEO\Adapter\ReferenceableInterface;
use Dedi\SyliusSEOPlugin\Domain\SEO\Adapter\ReferenceableTrait;
use Dedi\SyliusSEOPlugin\Entity\SEOContent;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;
use Dedi\SyliusSEOPlugin\Domain\SEO\Adapter\SeoAwareChannelInterface;
use Dedi\SyliusSEOPlugin\Domain\SEO\Adapter\SeoAwareChannelTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements SeoAwareChannelInterface, ReferenceableInterface
{
    use SeoAwareChannelTrait;

    use ReferenceableTrait {
        getMetadataTitle as getBaseMetadataTitle;
        getMetadataDescription as getBaseMetadataDescription;
    }

    public function getMetadataTitle(): ?string
    {
        if (is_null($this->getReferenceableContent()->getMetadataTitle())) {
            return $this->getName();
        }

        return $this->getBaseMetadataTitle();
    }

    public function getMetadataDescription(): ?string
    {
        if (is_null($this->getReferenceableContent()->getMetadataDescription())) {
            return $this->getDescription();
        }

        return $this->getBaseMetadataDescription();
    }

    protected function createReferenceableContent(): ReferenceableInterface
    {
        return new SEOContent();
    }
}
