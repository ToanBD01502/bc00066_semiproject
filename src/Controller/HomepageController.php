<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SanPham;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomepageController extends AbstractController
{
    #[Route('/feature', name: 'feature_product')]
    public function viewdetail(EntityManagerInterface $em): Response
    {
        $query = $em->createQuery('SELECT sp FROM App\Entity\SanPham sp');
        $lSp = $query->getResult();
                                
        return $this->render('homepage/sanpham.html.twig', [
            "data"=>$lSp
        ]);
    }
    #[Route('/category', name: 'app_category')]
    public function viewCate(EntityManagerInterface $em): Response
    {
        $query = $em->createQuery('SELECT category FROM App\Entity\Category category');
        $category = $query->getResult();
                                
        return $this->render('homepage/category.html.twig', [
            'category' => $category,
        ]);
    }
    #[Route('/feature/{id}', name: 'app_detailsp')]
    public function detail(EntityManagerInterface $em, int $id): Response
    {
        $sp = $em->find(SanPham::class, $id);

        return $this->render('homepage/detail.html.twig', [
            'data' => $sp,
        ]);
    }
    
    #[Route('/', name: 'homepage')]
    public function cate(EntityManagerInterface $em): Response
    {
        $query = $em->createQuery('SELECT category FROM App\Entity\Category category');
        $category = $query->getResult();

        $query = $em->createQuery('SELECT sp FROM App\Entity\SanPham sp');
        $lSp = $query->getResult();

        return $this->render('homepage/index.html.twig', [
            'category' => $category,
            'data'=>$lSp
        ]);
    }
    #[Route('/category/{id}', name: 'app_productofcate')]
    public function viewCategoryProducts(EntityManagerInterface $em, int $id, Request $request): Response
    {
        $cate = $em->find(Category::class, $id);
        $lSp = $cate->getSanPhams();
        return $this->render('homepage/sanpham.html.twig', [
            "data"=>$lSp
        ]);
    }
    #[Route('/profile', name: 'profile')]
    public function profile()
    {
        $user = $this->getUser();

        return $this->render('homepage/profile.html.twig', [
            'user' => $user,
        ]);
    }
}