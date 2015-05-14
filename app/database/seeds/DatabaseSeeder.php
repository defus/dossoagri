<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TestDataSeeder');
		$this->command->info('Database for tests seeded!');
	}

}

class TestDataSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();
        DB::table('utilisateur')->delete();

        User::create(array('Mail' => 'admin@dossoagri.com', 'Username' => 'admin', 'password' => Hash::make('admin'), 'nom' => 'Admin', 'prenom' => 'Utilisateur', 'isadmin' => 1));
        User::create(array('Mail' => 'agri1@dossoagri.com', 'Username' => 'agri1', 'password' => Hash::make('agri1'), 'nom' => 'agri1', 'prenom' => 'agri1', 'isadmin' => 0));
		User::create(array('Mail' => 'vend1@dossoagri.com', 'Username' => 'vend1', 'password' => Hash::make('vend1'), 'nom' => 'vend1', 'prenom' => 'vend1', 'isadmin' => 0));
		User::create(array('Mail' => 'part1@dossoagri.com', 'Username' => 'part1', 'password' => Hash::make('part1'), 'nom' => 'part1', 'prenom' => 'part1', 'isadmin' => 0));
        
        $admin = User::where('Username', 'admin')->firstOrFail();
        $part1 = User::where('Username', 'part1')->firstOrFail();
        $agri1 = User::where('Username', 'agri1')->firstOrFail();
        $vend1 = User::where('Username', 'vend1')->firstOrFail();
        
        Roles::create(array('Username' => $part1->Username, 'Role' => 'OPERATEUR'));
        Roles::create(array('Username' => $vend1->Username, 'Role' => 'OPERATEUR'));
        Roles::create(array('Username' => $agri1->Username, 'Role' => 'OPERATEUR'));
        
        // Charger les produits
        Produit::create(array('Ref' => 'PAPAYE', 'Nom' => 'Papaye'));
        Produit::create(array('Ref' => 'MANGUE', 'Nom' => 'Mangue'));
        
        $mangue = Produit::where('Ref', 'MANGUE')->firstOrFail();
        
        //Charger les recoltes pour les produit
        $recolte = new Recolte();
        $recolte->Poids = 10;
        $recolte->ProduitID = $mangue->ProduitID;
        $recolte->AgriculteurID = $agri1->UtilisateurID;
        $recolte->DateSoumission = '2015-10-10';
        $recolte->StatutSoumission = 'VALIDE';
        $recolte->CanalSoumission = 'INTERNET';
        $recolte->InitiateurID = $agri1->UtilisateurID;
        $recolte->save();

        
    }

}
