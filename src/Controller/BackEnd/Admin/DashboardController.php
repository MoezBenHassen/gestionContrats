<?php

namespace App\Controller\BackEnd\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\BackEnd\FournisseurCrudController;
use App\Entity\Fournisseur;
use App\Entity\Contrat;
use App\Entity\Convention;
use App\Entity\TypesContrat;
use App\Entity\User;
use App\Entity\Admin;
use App\Repository\ContratRepository;
use App\Repository\ConventionRepository;
use App\Repository\AdminRepository;
use App\Repository\UserRepository;

class DashboardController extends AbstractDashboardController
{
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'userSum' => $this->userSum ,
            'adminSum' => $this->adminSum ,
            'contratSum' => $this->contratSum ,
            'conventionSum' => $this->conventionSum ,
        ]);
    }

    public $userSum, $adminSum, $contratSum, $conventionSum;
    public function __construct(ContratRepository $contrat, ConventionRepository $convention, AdminRepository $admin, UserRepository $user )
    {
        $this->userSum = count($user->findAll());
        $this->adminSum = count($admin->findAll());
        $this->contratSum = count($contrat->findAll());
        $this->conventionSum = count($convention->findAll());
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ATCT');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        if($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::section('Configuration');
            yield MenuItem::linkToCrud('Types des contrats', 'fas fa-list', TypesContrat::class);

            yield MenuItem::section('Controle des utilisateurs');
            yield MenuItem::linkToCrud('Admins', 'fas fa-user', Admin::class);
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        }
        if($this->isGranted('ROLE_USER')){
            yield MenuItem::section('Contrats et Conventions');
            yield MenuItem::linkToCrud('Fournisseurs', 'fa fa-tags', Fournisseur::class);
            yield MenuItem::linkToCrud('Contrats', 'fa fa-file-text', Contrat::class);
            yield MenuItem::linkToCrud('Conventions', 'fa fa-file-text', Convention::class);
        }
    }
}
