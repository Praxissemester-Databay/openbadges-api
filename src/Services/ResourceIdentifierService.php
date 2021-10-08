<?php

namespace App\Services;

use App\Entity\Assignment;
use App\Entity\Issuer;
use App\Entity\Recipient;
use App\Entity\Badge;
use Symfony\Component\HttpFoundation\Response;
use http\Exception\InvalidArgumentException;
use App\Form\RecipientType;
use App\Form\AssignmentType;
use App\Form\IssuerType;
use App\Form\BadgeType;

class ResourceIdentifierService
{
    /**
     * @var ResourceIdentifierService
     */
    private static $instance;

    public function __construct()
    {
    }

    public static function getInstance() : self
    {
        if (self::$instance) {
            return self::$instance;
        }

        return self::$instance = new self();
    }

    /**
     * @param $resource
     * @return string
     * @trhows InvalidArgumentException
     */
    public function identify($resource) : array
    {
        switch($resource) {
            case 'badge':
                $class = Badge::class;
                $type = BadgeType::class;
                break;
            case 'issuer':
                $class = Issuer::class;
                $type = IssuerType::class;
                break;
            case 'assignment':
                $class = Assignment::class;
                $type = AssignmentType::class;
                break;
            case 'recipient':
                $class = Recipient::class;
                $type = RecipientType::class;
                break;
            default:
                throw new InvalidArgumentException('Not a valid resource');
                break;
        }
        return [$class, $type];
    }
}
