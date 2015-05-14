<?php

class RecolteSMSTest extends TestCase {

  public function testCrudRecolte()
  {
    $user = new User();
    $user->login(array('email' => 'part1', 'password' => 'part1'));
    
    
	//La collecte des recolte par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = '22793339999'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'Mangue 50'; // Contenu du message
    
    //Création entité
    $response = $this->call('GET', '/recolte/addsms/ajax', $dataSubmission);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('recolte');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/recolte\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $recolteIdFinded);
    $this->assertCount(2, $recolteIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $recolteId = $recolteIdFinded[1][0];;

    /*
    //modification des informations 
    $recolte1 = array();
    $recolte1['Poids'] = 100; //Poids de la recolte (kg)
    $recolte1['ProduitID'] = 1; //Reference au produit recolté
    $recolte1['AgriculteurID'] = 1; //C'est la reference vers la personne qui a soumis la culture ou l'elevage
    $recolte1['DateSoumission'] = '10/05/2015';
    $recolte1['StatutSoumission'] = 'SOUMIS'; // SOUMIS, VALIDE
    $recolte1['CanalSoumission'] = 'INTERNET'; //INTERNET, SMS, TELEPHONE
    
    $response = $this->call('PUT', '/recolte/' . $recolteId, $recolte1);

    $this->assertRedirectedTo('recolte');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/recolte\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $recolteIdFinded);
    $this->assertCount(2, $recolteIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");
*/
    //Suppression
    $response = $this->call('DELETE', '/recolte/' . $recolteId);

  }

}
