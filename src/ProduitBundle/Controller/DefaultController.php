<?php

namespace ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $prods = $em->getRepository(Prods::class)->findAll();
        $total=0;
        $totalsucre=0;
        $totalsale=0;
        foreach($prods as $prod) {
            $total++;
            if($prod->getCategoriepro()=="Sucre")
            {$totalsucre++;}
            if($prod->getCategoriepro()=="sale")
            {$totalsale++;}
        }
        $data= array();
        $stat=['Categorie', 'nbr'];
        $nb=0;
        array_push($data,$stat);

        array_push($stat,"sucre",($totalsucre *100)/$total);
        $nb=$totalsucre ;
        $stat=["sucre",$nb];
        array_push($data,$stat);

        array_push($stat,"sale",($totalsale *100)/$total);
        $nb=$totalsale ;
        $stat=["sale",$nb];
        array_push($data,$stat);



        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(1700);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $pieChart->getOptions()->setIs3D(true);

        return $this->render('@Produit/prods/stat.html.twig', array('piechart' => $pieChart));

    }
}
