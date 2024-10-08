<?php

namespace App\Controller\BackEnd;

use App\Entity\Contrat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ContratCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contrat::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('objet'),
            AssociationField::new('numFournisseur','Fournisseur'),
            DateField::new('dateDebut','Debut'),
            DateField::new('dateFin','Fin'),
            IntegerField::new('preavis'),
            MoneyField::new('montant')->setCurrency('TND'),
            IntegerField::new('numEnregistrement'),
            AssociationField::new('Type'),
            ChoiceField::new('periodiciteFacturation')
            ->setChoices([
                'Mensuel'=>'Mensuel',
                'Trimestriel'=>'Trimestriel',
                'Semestriel'=>'Semestriel',
                'Annuel'=>'Annuel',
            ])
            ->renderExpanded(),
            TextField::new('periodiciteEntretien'),
            NumberField::new('augmentation'),
            BooleanField::new('suivi'),
            BooleanField::new('repetitive'),
            TextareaField::new('filePDF','PDF')->setFormType(VichFileType::class)->hideOnIndex(),
            TextField::new('libellePDF','PDF')->hideOnForm()->setTemplatePath('admin/showPDF.html.twig'),
        ];
    }

}
