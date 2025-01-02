<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DeleteFormComponent', template: 'shared_kernel/components/commons/delete_form_component.html.twig')]
class DeleteFormComponents
{
    public ?string $classId = '';
    public string $id;
    public ?string $confirmText = "Etes vous sûr de supprimer cet enregistrement ?";
    public ?string $label = "Supprimer";
}