    <?php  
    require('JSONAPI.php');
     
    //on remplie les paramètres de connection à JSONAPI
     
    $ip = '188.165.212.46:29384'; // Ip du serveur
    $port = 30015; //port du plugin (par défaut : 20059)
    $user = 'admin'; //nom d'utilisateur
    $pass ='rsrea7abapw3aru'; //mot de passe  
    $salt ='salt'; //phrase clé
    $api = new JSONAPI($ip, $port, $user, $pass, $salt);
     
    //fonction pour afficher les tableaux de données proprement
       function preint_r($array)
       {
          echo '<pre>';
          print_r($array);
          echo '</pre>';
       }
     
     
    //---------- On vérifie la validité du pseudo. Est-ce un compte premium ? Cela vérifie par la même occasion l'orthographe du pseudo.
    $pseudo = $_POST['pseudo'];
     
    $valid_pseudo = file_get_contents("http://minecraft.net/haspaid.jsp?user=$pseudo", "r");
     
    //Si le pseudo n'est pas un compte premium ou si il comporte des erreurs, nous affichons un message d'erreur sinon nous vérifions qu'il n'est pas déjà joueur.
            if ($valid_pseudo=="false"){
            echo '<div class="erreur">Apparemment, vous n’avez pas acheté le jeu Minecraft ou alors vous avez commis une faute dans la saisie de votre pseudo</div>';
            }
            else {
                   
                    $verif_groupe = $api->call("permissions.getGroups", array("$pseudo"));
                    echo preint_r($verif_groupe["success"]);
     
                    // IMPORTANT : Vous devez changez mes groupes par les votre.
                   
                    if($verif_groupe["success"][0]=="Moderateur(e)"){
                   
                    echo '<div class="ok">Votre pseudo est valide. Vous êtes présent Citoyen :D Bon jeu !</div>';
                    $commande = "manpromote $pseudo builder";
                    $api->call("runConsoleCommand", array("$commande"));
                   
                    }
                    else {
                    echo '<div class="info">Vous êtes déjà Citoyen !</div>';
                    }
     
     
            }      
    ?>

