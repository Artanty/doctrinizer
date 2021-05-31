<?php

namespace App\Entities\Tag;

use App\Entities\ProductTag\ProductTag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Тэги
 *
 * @ORM\Entity
 * @ORM\Table(name="`Tags`")
 */
class Tag
{
    /**
     * Идентификатор
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint", name="`Id`")
     */
    protected $id;

    /**
     * Значение
     *
     * @var string
     * @ORM\Column(type="string", name="`Value`", nullable=false)
     */
    protected $value;

    /**
     * Идентификатор заказчика (Юбилейный)
     *
     * @var integer
     * @ORM\Column(type="bigint", name="`CustomerId`", nullable=true)
     */
    protected $customerId;

    /**
     * Признак архивации
     *
     * @var integer
     * @ORM\Column(type="smallint", name="`Removed`", nullable=true)
     */
    protected $removed;

    /**
     * Действует до
     *
     * @var string
     * @ORM\Column(type="string", name="`TimestampTo`", nullable=true)
     */
    protected $timestampTo;

    /**
     * Связь с таблицей продуктов с тегами
     *
     * @ORM\OneToMany(targetEntity="App\Entities\ProductTag\ProductTag", mappedBy="tag", fetch="LAZY")
     */
    private $productTags;

    public function __construct() {
        $this->productTags = new ArrayCollection();
    }

    /**
     * @return Collection|ProductTag[]
     */
    public function getProductTags(): Collection
    {
        return $this->productTags;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getRemoved()
    {
        return $this->removed;
    }

    public function setRemoved($removed)
    {
        $this->removed = $removed;
    }

    public function getKey()
    {
        return $this->getId();
    }

}
