<style>
    aside{
            background-color: #D9D9D9;
            height: 100dvh;
            width: 270px;
            display: flex;
            flex-direction: column;
            align-items: center; 
            justify-content: space-between;
            font-size: 1.25rem;
        }

        .aside-top{
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile{
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: bold;
        }

        .profile-image{
            width: 118px;
            height: 118px;
            border-radius: 99999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: normal;
            font-size: 0.875rem;
        }

        .sidebar-menu{
            list-style: none;
            padding-inline: 0;
            align-self: flex-start;
        }
        .sidebar-menu>li{
            margin: 1rem 0;
        }

        .logout{
            justify-self: flex-end;
        }
</style>

<aside>
    <section class="aside-top">
        <h2>Cognitio</h2>

        <div class="profile">
            <img src="https://placehold.co/400/A27474/FFF?text=C" alt="Profilbilde" class="profile-image">
            <p>Christine Nilsen</p>
            <ul class="sidebar-menu">
                <li><a href="#">Oppgaver</a></li>
                <li><a href="#">Emner</a></li>
                <li><a href="#">Samarbeid</a></li>
                <li><a href="#">Gjøremål</a></li>
            </ul>
        </div>
    </section>




    <div class="logout">
        <p><a href="">&larr; Logg ut</a></p>
    </div>


</aside>