<?php

namespace App\Services;

use App\Entity\Assignment;
use App\Entity\Issuer;
use App\Entity\Recipient;
use App\Entity\Badge;
use DateTime;

class JsonService
{
    /**
     * @var JsonService
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

    public function objectToJson($object) : array {
        $json = [];
        foreach(get_class_methods($object) as $method) {
            if(!str_starts_with($method, 'get')) {
                continue;
            }
            if($object instanceof Assignment || $object instanceof Issuer || $object instanceof Recipient || $object instanceof Badge) {

                $res = $object->$method();
                $json[str_replace('get' , '', strtolower($method))] = is_object($res) ? $this->objectToJson($res) : $res;
            }
        }
        return $json;
    }

    public function objectToApiJson($object, $resource, $baseUrl) : array {
        switch($resource) {
            case 'badge': return $this->badgeJsonBuilder($object, $baseUrl);
            case 'issuer': return $this->issuerJsonBuilder($object, $baseUrl);
            case 'assignment': return $this->assignmentJsonBuilder($object, $baseUrl);
        }
        return [];
    }

    private function badgeJsonBuilder(Badge $badge, $baseUrl) : array {
        return [
                "@context" => "https://w3id.org/openbadges/v2",
                "type" => "BadgeClass",
                "id" =>  $baseUrl . "/badge_api/badge/" . $badge->getId(),
                "name" => $badge->getName(),
                "description" => $badge->getDescription(),
                "issuer" =>  $baseUrl . "/badge_api/issuer/" . $badge->getIssuer()->getId(),
                "image" => $badge->getImage() ?? '',
                "criteria" => [
                    "narrative" => "Kriterien"
                ],
                "alignment" => [],
                "tags" => []
            ];
    }

    private function issuerJsonBuilder(Issuer $issuer, $baseUrl) : array {
        return [
          "@context" => "https://w3id.org/openbadges/v2",
          "type" => "Issuer",
          "id" => $baseUrl . "/badge_api/issuer/" . $issuer->getId(),
          "name" => $issuer->getName(),
          "url" => $issuer->getUrl(),
          "email" => $issuer->getEmail(),
          "description" => $issuer->getDescription(),
          "image" => $issuer->getImage()
        ];
    }

    private function assignmentJsonBuilder(Assignment $assignment, $baseUrl) : array {
        return [
            "@context" => "https://w3id.org/openbadges/v2",
            "type" => "Assertion",
            "id" => $baseUrl . "/badge_api/assignment/" . $assignment->getId(),
            "badge" => $baseUrl . "/badge_api/badge/" . $assignment->getBadge()->getId(),
            "image" => $assignment->getImage(),
            "verification" => [
                "type" => "HostedBadge"
            ],
            "narrative" => $assignment->getNarrative(),
            "issuedOn" => $assignment->getIssuedOn()->format(DATE_W3C),
            "recipient" => [
                "hashed" => $assignment->getRecipient()->getHashed(),
                "type" => $assignment->getRecipient()->getType(),
                "identity" => $assignment->getRecipient()->getIdentity(),
                "salt" => $assignment->getRecipient()->getSalt(),
            ]
        ];
    }
}
