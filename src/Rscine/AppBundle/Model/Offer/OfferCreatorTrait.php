<?php

namespace Rscine\AppBundle\Model\Offer;

use Rscine\AppBundle\Entity\Offer;

/**
 * Représente un utilisateur pouvant créer des offres
 */
trait OfferCreatorTrait
{
    /**
     * @var ArrayCollection<Offer>
     *
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="creator")
     */
    private $offersCreated;

    /**
     * @{inheritdoc}
     */
    public function getOffersCreated()
    {
        return $this->offersCreated;
    }

    /**
     * @{inheritdoc}
     */
    public function addOfferCreated(Offer $offer)
    {
        if (!$this->offersCreated->contains($offer)) {
            $this->offersCreated->add($offer);

            $offer->setCreator($this);
        }

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function removeOfferCreated(Offer $offer)
    {
        if ($this->offersCreated->contains($offer)) {
            $this->offersCreated->removeElement($offer);

            $offer->setCreator(null);
        }

        return $this;
    }
}
