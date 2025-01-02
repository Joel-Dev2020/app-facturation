<?php

namespace App\IdentityAndAccess\Presentation\Components\User;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('UserFilterComponent', template: 'identity_and_access/admin/user/components/user_filter_component.html.twig')]
class UserFilterComponents
{
    public ?FormView $form = null;
    public ?string $id = null;
    public ?string $title = null;
}