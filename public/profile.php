<?php
// Start bruker-session.
session_start();

// Er bruker innlogget?
if (!$_SESSION['loggedin']) {
    header('Location: ./index.php');
    exit;
}

require_once '../src/account.php';
$account = unserialize($_SESSION['account']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Profil</title>
    <style>
        .profile-view {
            display: grid;
            grid-template-columns: 100px 1fr;
            align-items: start;
        }

        li:not(:first-child) {
            margin: 0.5rem 0;
        }

        li {
            display: flex;
            align-items: center;

            svg {
                margin-right: 0.25rem;
                fill: var(--text-clr);
            }
        }

        .profile_image_container {
            display: flex;
            justify-content: center;
            width: 100%;
            position: relative;
        }

        .profile_picture {
            justify-self: center;
        }

        #edit_profile_image {
            width: 40px;
            height: 40px;
            position: absolute;
            bottom: -10px;
            right: 10px;
            cursor: pointer;
            display: none;
        }

        .profile_image_container:hover>#edit_profile_image {
            display: block;
        }

        /* Skjul det opprinnelige filopplastingsfeltet */
        .file-input {
            display: none;
        }

        /* Style for tilpasset knapp */
        .custom-file-upload {
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #83BF73;
            color: white;
            border-radius: 4px;
            font-weight: 100;
        }

        /* Style for visning av filnavnet */
        .file-name {
            margin-left: 10px;
            font-style: italic;
            color: #555;
        }

        .dialog_header {
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php
    $page = 'profile';
    include("./inc/sidebar.inc.php");
    //phpinfo();
    ?>
    <div class="content">
        <section class="top-section">
            <h2>Brukerprofil</h2><br />
        </section>
        <div class="profile-view">
            <div class="profile_image_container">
                <button id="edit_profile_image">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                    </svg>
                </button>
                <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" alt="" class="profile_picture"> -->
                <img src=<?php if ($account->getProfileUrl()) {
                                echo "../src/" . $account->getProfileUrl() . " ";
                            } else {
                                echo "https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png";
                            } ?> alt="" class="profile_picture">
            </div>
            <ul class="no-style">
                <li>

                    <h3><?= htmlspecialchars($account->getFirstName() . " " . $account->getLastName(), ENT_QUOTES) ?></h3>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                        <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z" />
                    </svg>
                    <?= htmlspecialchars($account->getUsername(), ENT_QUOTES) ?>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                        <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                    </svg> <?= htmlspecialchars($account->getEmail(), ENT_QUOTES) ?>
                </li>
            </ul>
            <!--             <table>
                <tr>
                    <td>Fornavn:</td>
                    <td><?= htmlspecialchars($account->getFirstName(), ENT_QUOTES) ?></td>
                </tr>
                <tr>
                    <td>Etternavn:</td>
                    <td><?= htmlspecialchars($account->getLastName(), ENT_QUOTES) ?></td>
                </tr>
                <tr>
                    <td>Brukernavn:</td>
                    <td><?= htmlspecialchars($account->getUsername(), ENT_QUOTES) ?></td>
                </tr>
                <tr>
                    <td>E-post:</td>
                    <td><?= htmlspecialchars($account->getEmail(), ENT_QUOTES) ?></td>
                </tr>
            </table> -->
        </div>
    </div>

    <!-- Dialog for å laste opp profilbilde -->
    <dialog id="upload_profile_image">
        <form action="../src/update_profile_image.php" method="post" enctype="multipart/form-data">
            <h3 class="dialog_header">Last opp nytt profilblide</h3>
            <label class="custom-file-upload">
                Velg fil
                <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp" class="file-input" onchange="updateFileName()">
            </label>
            <span class="file-name" id="file-name">Ingen fil valgt</span> <br /><br /><br />

            <button id="cancel">Avbryt</button>
            <input type="submit" value="Legg til bilde">
        </form>
    </dialog>



    <script src="./resources/js/app.js"></script>
    <script>
        const uploadProfileImage = document.getElementById('upload_profile_image');
        const editProfileImage = document.getElementById('edit_profile_image');
        const cancel = document.getElementById('cancel');

        editProfileImage.addEventListener("click", () => {
            uploadProfileImage.showModal();
        });

        cancel.addEventListener("click", (e) => {
            e.preventDefault();
            uploadProfileImage.close();
        });

        function updateFileName() {
            const input = document.getElementById('image');
            const fileName = document.getElementById('file-name');
            fileName.textContent = input.files.length > 0 ? input.files[0].name : "Ingen fil valgt";
        }
    </script>

</body>

</html>