<?php

class UserTest extends TestCase {

  public function testCrudUser()
  {
    $user = new User();
    $user->login(array('email' => 'admin', 'password' => 'admin'));

    $user1 = array();
    $user1['Mail'] = 'test1@dossoagri.com';
    $user1['Username'] = 'test1';
    $user1['isadmin'] = '0';
    $user1['password'] = 'test1';
    $user1['password_confirmation'] = 'test1';
    
    //Création alerte
    $response = $this->call('POST', '/admin/user', $user1);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('alert');
    $this->assertSessionHas('alert.success');
    
    //Vérifier que la réponse contient l'url de l'alerte pour modification
    $message = $response->getSession()->get('alert.success');
    $content = $response->getContent();
    $pattern = "/admin\/user\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $alertIdFinded);
    $this->assertCount(2, $alertIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $alertId = $alertIdFinded[1][0];;

    //modification des informations 
    $user1 = array();
    $user1['Username'] = 'test1';
    $user1['isadmin'] = '0';
    $user1['password'] = 'test1';
    $user1['password_confirmation'] = 'test1';

    $response = $this->call('PUT', '/admin\/user/' . $alertId, $user1);

    $this->assertRedirectedTo('alert');
    $this->assertSessionHas('alert.success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('alert.success');
    $content = $response->getContent();
    $pattern = "/admin\/user\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $alertIdFinded);
    $this->assertCount(2, $alertIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression du batiment
    $response = $this->call('DELETE', '/admin/user/' . $alertId);

  }

}
