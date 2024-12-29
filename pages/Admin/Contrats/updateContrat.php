<?php 

require_once __DIR__ . '/../../../vendor/autoload.php';

session_start();

use User\LocationPoo\Models\Contrat;
use User\LocationPoo\Models\Validator;
use User\LocationPoo\Models\User;
use User\LocationPoo\Models\Voiture;

Validator::validateAdmin();

$users = new User(); 
$voitures = new Voiture();

$usersIds = $users->getUsersIds();
$voituresIds = $voitures->getVoituresIds();

if(isset($_GET['id'])){

    $id_contrat = (int) $_GET['id'];

    $contrat = new Contrat();
    $contrat_infos = $contrat->getContrat($id_contrat);

}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['updateContrat'])){

        Validator::validateCsrf();

        $id_contrat = (int) $_POST['id_contrat'];
        $dateDebut = trim($_POST['dateDebut']);
        $dateFin = trim($_POST['dateFin']);
        $id_user = (int) $_POST['id_user'];
        $id_voiture = (int) $_POST['id_voiture'];

        $contrat = new Contrat();
        $contrat->updateContrat($id_contrat, $id_user, $id_voiture, $dateDebut, $dateFin);

    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$dateDebutErr = $_SESSION["dateDebutErr"] ?? null;
$dateFinErr = $_SESSION["dateFinErr"] ?? null;
$idUserErr = $_SESSION["idUserErr"] ?? null;
$idVoitureErr = $_SESSION["idVoitureErr"] ?? null;
$message = $_SESSION["message"] ?? null;

unset($_SESSION["dateDebutErr"],$_SESSION["dateFinErr"], $_SESSION["idUserErr"],$_SESSION["idVoitureErr"],$_SESSION["message"]);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un contrat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 overflow-x-hidden">

    <div class="flex min-h-screen">
        <?php include_once "../../layouts/sidebar.php";?>

        <div class="flex-1 p-6">
            <?php include_once "../../layouts/statics.php";?>
            <?php 
            if($message){
                echo "
                    <div class='max-w-3xl mx-auto bg-green-600 rounded-lg my-5 py-5 ps-5'>
                        <p class='text-white font-bold'>$message</p>
                    </div>
                ";
            }
            ?>

            <div class="mt-6 flex justify-center items-center">
               <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-xl">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Modifier un contrat</h1>
                    <form method="POST">

                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <input type="hidden" name="id_contrat" value="<?php if ($contrat_infos) echo $contrat_infos['id_contrat']; ?>">

                        <div class="mb-4">
                            <label for="dateDebut" class="block text-sm font-medium text-gray-600">Date de début</label>
                            <input type="date" name="dateDebut" placeholder="Entrez la date de début" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105" value="<?php if ($contrat_infos) echo $contrat_infos['DateDebut']; ?>">
                            <?php if($dateDebutErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$dateDebutErr</p><br>" ?>
                        </div>

                        <div class="mb-4">
                            <label for="dateFin" class="block text-sm font-medium text-gray-600">Date de fin</label>
                            <input type="date" name="dateFin" placeholder="Entrez la date de fin" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105" value="<?php if ($contrat_infos) echo $contrat_infos['DateFin']; ?>">
                            <?php if($dateFinErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$dateFinErr</p><br>" ?>
                        </div>

                        <div class="mb-4">
                            <label for="id_user" class="block text-sm font-medium text-gray-600">Utilisateur</label>
                            <select name="id_user" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105">
                                <option>-- Select Client ID --</option>
                                <?php 
                                    if($usersIds->num_rows > 0){
                                        while($row = $usersIds->fetch_assoc()){
                                            echo "<option ". ( ($contrat_infos && $contrat_infos['id_user'] == $row['id_user']) ? 'selected' : null) ." value='{$row['id_user']}'>{$row['id_user']}</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <?php if($idUserErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$idUserErr</p><br>" ?>
                        </div>

                        <div class="mb-4">
                            <label for="id_voiture" class="block text-sm font-medium text-gray-600">Voiture</label>
                            <select name="id_voiture" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105">
                                <option>-- Select Voiture ID --</option>
                                <?php 
                                    if($voituresIds->num_rows > 0){
                                        while($row = $voituresIds->fetch_assoc()){
                                            echo "<option ". ( ($contrat_infos && $contrat_infos['id_voiture'] == $row['id_voiture']) ? 'selected' : null) ." value='{$row['id_voiture']}'>{$row['id_voiture']}</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <?php if($idVoitureErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$idVoitureErr</p><br>" ?>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="updateContrat"
                            class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:from-purple-600 hover:to-pink-600 focus:outline-none focus:ring-4 focus:ring-purple-300">
                                Modifier le contrat
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 KSBlog. Tous droits réservés.</p>
        </div>
    </footer>

</body>

</html>
