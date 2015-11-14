<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Offer
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("ALL")
 */
class Offer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Serializer\Expose
     */
    private $description;

    /**
     * Créateur de la demande (utilisateur client)
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="offers")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $creator;

    /**
     * Candidats à la demande
     * @var Array<Contractor>
     *
     * @ORM\ManyToMany(targetEntity="Contractor", inversedBy="offersAppliedTo", cascade={"persist"})
     * @ORM\JoinTable(name="offers_applications",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="applicant_id", referencedColumnName="id")}
     *      )
     */
    private $applicants;

    /**
     * Maître d'oeuvre
     * @var Contractor
     *
     * @ORM\ManyToOne(targetEntity="Contractor", inversedBy="offersHandled")
     * @ORM\JoinColumn(name="handler_id", referencedColumnName="id")
     */
    private $handler;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    private $updated;

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("creator_id")
     */
    public function getCreatorId()
    {
        return ($this->getCreator()) ? $this->getCreator()->getId() : null;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("handler_id")
     */
    public function getHandlerId()
    {
        return ($this->getHandler()) ? $this->getHandler()->getId() : null;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("applicants")
     */
    public function getApplicantsIds()
    {
        $ids = array();
        foreach ($this->getApplicants() as $applicant) {
             $ids[] = $applicant->getId();
         } 
         return $ids;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Offer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->applicants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set creator
     *
     * @param \AppBundle\Entity\Customer $creator
     *
     * @return Offer
     */
    public function setCreator(\AppBundle\Entity\Customer $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Add applicant
     *
     * @param \AppBundle\Entity\Contractor $applicant
     *
     * @return Offer
     */
    public function addApplicant(\AppBundle\Entity\Contractor $applicant)
    {
        $this->applicants[] = $applicant;
        $applicant->addOfferAppliedTo($this);

        return $this;
    }

    /**
     * Remove applicant
     *
     * @param \AppBundle\Entity\Contractor $applicant
     */
    public function removeApplicant(\AppBundle\Entity\Contractor $applicant)
    {
        $this->applicants->removeElement($applicant);
        $applicant->removeOfferAppliedTo($this);
    }

    /**
     * Get applicants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplicants()
    {
        return $this->applicants;
    }

    /**
     * Set handler
     *
     * @param \AppBundle\Entity\Contractor $handler
     *
     * @return Offer
     */
    public function setHandler(\AppBundle\Entity\Contractor $handler = null)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get handler
     *
     * @return \AppBundle\Entity\Contractor
     */
    public function getHandler()
    {
        return $this->handler;
    }
}