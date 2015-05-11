<?php

class AlertTest extends TestCase {

  public function testCreatAlert()
  {
    $user = new User();
    //Ali est fonctionnaire
    $user->login(array('email' => 'ali', 'password' => 'ali'));

    $alert = array();
    $alert['Nom'] = 'Hôtel de ville';
    $alert['Adresse1'] = 'Adresse 1';
    $alert['Adresse2'] = 'Adresse2';
    $alert['Adresse3'] = 'Adresse3';
    $alert['altitude'] = 'altitude';
    $alert['Latitude'] = 'Latitude';
    $alert['Longitude'] = 'Longitude';
    
    //Création alerte
    $response = $this->call('POST', '/alert', $alert);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('alert');
    $this->assertSessionHas('alert.success');
    
    //Vérifier que la réponse contient l'url de l'alerte pour modification
    $message = $response->getSession()->get('alert.success');
    $content = $response->getContent();
    $pattern = "/alert\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $alertIdFinded);
    $this->assertCount(2, $alertIdFinded, "Après la création d'une alerte, la vue qui suit doit contenir le numero de l'alerte dans le lien de modification");

    $alertId = $alertIdFinded[1][0];;

    //modification des informations 
    $alert = array();
    $alert['Nom'] = 'Hôtel de ville';
    $alert['Adresse1'] = 'Adresse 1';
    $alert['Adresse2'] = 'Adresse2';
    $alert['Adresse3'] = 'Adresse3';
    $alert['altitude'] = 'altitude';
    $alert['Latitude'] = 'Latitude';
    $alert['Longitude'] = 'Longitude';

    $response = $this->call('PUT', '/alert/' . $alertId, $alert);

    $this->assertRedirectedTo('alert');
    $this->assertSessionHas('alert.success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('alert.success');
    $content = $response->getContent();
    $pattern = "/alert\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $alertIdFinded);
    $this->assertCount(2, $alertIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression du batiment
    $response = $this->call('DELETE', '/alert/' . $alertId);

  }

}
