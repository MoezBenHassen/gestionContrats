<?php

namespace App\Controller\BackEnd;

use App\Entity\Convention;
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
use Vich\UploaderBundle\Form\Type\VichFileType;

class ConventionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Convention::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('objet'),
            AssociationField::new('numFournisseur','Fournisseur'),
            DateField::new('dateDebut','Debut'),
            DateField::new('dateFin','Fin'),
            MoneyField::new('montant')->setCurrency('TND'),
            TextareaField::new('filePDF','PDF')->setFormType(VichFileType::class)->hideOnIndex(),
            TextField::new('libellePDF','PDF')->hideOnForm()->setTemplatePath('admin/showPDF2.html.twig'),
        ];
    }
    
}
