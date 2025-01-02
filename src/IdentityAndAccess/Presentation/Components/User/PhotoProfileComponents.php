<?php

namespace App\IdentityAndAccess\Presentation\Components\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('PhotoProfileComponent', template: 'identity_and_access/admin/user/components/photo_profile_component.html.twig')]
class PhotoProfileComponents extends AbstractController
{
}