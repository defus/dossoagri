<?php

class NegociationRecolteTest extends TestCase {

  public function testCrudNegociationRecolte()
  {
    $user = new User();
    $user->login(array('email' => 'achat1', 'password' => 'achat1'));

    $negociationrecolte1 = array();
    $negociationrecolte1['Prix'] = 100; //Prix proposé par l'acheteur
    $negociationrecolte1['RecolteID'] = 1; //C'est la reference vers la personne qui a appartient la culture ou l'elevage
    $negociationrecolte1['StatutProposition'] = 'PREPARATION'; // PREPARATION, PUBLIE Une proposition peut-etre validée par une persone autorisée. Dans ce cas, elle est pousée vers l'agriculteur' 
    
    //Création entité
    $response = $this->call('POST', '/negociationrecolte/1/store', $negociationrecolte1);
    $this->assertResponseStatus(302);
  
    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('negociationrecolte');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/negociationrecolte\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $negociationrecolteIdFinded);
    $this->assertCount(2, $negociationrecolteIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $negociationrecolteId = $negociationrecolteIdFinded[1][0];;
    
    //vérifier que la liste contient la nouvelle entité
    //http://symfony.com/doc/master/components/dom_crawler.html
    $crawler = $this->client->request('GET', '/negociationrecolte');
    $this->assertTrue($this->client->getResponse()->isOk());
    
    $response = $this->call('GET', '/negociationrecolte/datatable/ajax');
    $this->assertResponseOk();
    
    //modification des informations 
    $negociationrecolte1 = array();
    $negociationrecolte1['Prix'] = 100; //Prix proposé par l'acheteur
    $negociationrecolte1['RecolteID'] = 1; //C'est la reference vers la personne qui a appartient la culture ou l'elevage
    $negociationrecolte1['StatutProposition'] = 'PREPARATION'; // PREPARATION, PUBLIE Une proposition peut-etre validée par une persone autorisée. Dans ce cas, elle est pousée vers l'agriculteur'
    
    $response = $this->call('PUT', '/negociationrecolte/' . $negociationrecolteId, $negociationrecolte1);
    $this->assertResponseStatus(302);

    $this->assertRedirectedTo('negociationrecolte');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/negociationrecolte\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $recolteIdFinded);
    $this->assertCount(2, $negociationrecolteIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression
    $response = $this->call('DELETE', '/negociationrecolte/' . $negociationrecolteId);
    $this->assertResponseStatus(302);

  }

}
