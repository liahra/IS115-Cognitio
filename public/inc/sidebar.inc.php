<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../resources/js/app.js" defer></script>

    <title>Sidebar</title>
</head>

<body>
    <nav id="sidebar">
        <ul>
            <li>
                <span class="logo">Cognitio</span>
                <button onclick=toggleSidebar() id="toggle-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z" />
                    </svg>
                </button>
            </li>
            <li class="active">
                <a href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M240-200h120v-200q0-17 11.5-28.5T400-440h160q17 0 28.5 11.5T600-400v200h120v-360L480-740 240-560v360Zm-80 0v-360q0-19 8.5-36t23.5-28l240-180q21-16 48-16t48 16l240 180q15 11 23.5 28t8.5 36v360q0 33-23.5 56.5T720-120H560q-17 0-28.5-11.5T520-160v-200h-80v200q0 17-11.5 28.5T400-120H240q-33 0-56.5-23.5T160-200Zm320-270Z" />
                    </svg>
                    <span>Hjem</span>
                </a>
            </li>
            <li>
                <a href="profile.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                    </svg>
                    <span>Profil</span>
                </a>
            </li>
        </ul>
    </nav>
    <!--     <main>
        <div class="container">
          <h2>Hello World</h2>
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veritatis porro iure quaerat aliquam! Optio dolorum in eum provident, facilis error repellendus excepturi enim dolor deleniti adipisci consectetur doloremque, unde maiores odit sapiente. Atque ab necessitatibus laboriosam consequatur eius similique, ex dolorum eum eaque sequi id veritatis voluptates perspiciatis, cupiditate pariatur.</p>
        </div>
        <div class="container">
          <h2>Example Heading</h2>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic aliquid corrupti, tenetur fuga magnam necessitatibus blanditiis quod sint excepturi laborum esse alias labore molestias adipisci, nostrum corporis ex maiores quis dolore quidem asperiores odio ad fugit eos! Delectus modi quas ipsa deleniti consequuntur nihil, hic in ipsum exercitationem blanditiis natus, ex, expedita eos. Excepturi quidem harum hic nam magnam deserunt illum quis dolorum eos ipsum ut natus sapiente sit, officia obcaecati assumenda tempore molestias? In fugiat iure laboriosam quasi, eum suscipit, harum autem saepe ut, soluta aspernatur ducimus eos magnam quidem officiis. Laboriosam nemo explicabo delectus, et quos vero cum?</p>
        </div>
        <div class="container">
          <h2>Lorem Ipsum</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore repudiandae labore veniam reprehenderit voluptatum, laboriosam perferendis fuga, dolore quam quas nostrum totam sunt esse expedita. Vero distinctio omnis accusantium. Quisquam ullam saepe cupiditate magni numquam totam perspiciatis error velit, debitis veniam labore possimus aut sunt, reiciendis natus. Impedit provident voluptatum nulla fuga error a magnam, corporis natus aperiam fugit quod perferendis quos quaerat, numquam sequi doloribus tenetur dolorem voluptate deleniti, odio minus. Deserunt eius quasi odit voluptas unde voluptatum dicta cumque exercitationem soluta beatae porro distinctio, delectus officiis, nobis officia ullam necessitatibus, rem natus corrupti nam! Est, nihil molestias fugiat sed quae enim commodi expedita soluta tempore molestiae fuga adipisci rem esse voluptates quos, ut quasi sunt ad a perspiciatis ducimus maxime animi. Adipisci officia doloribus magni alias maiores ab quo, eos mollitia sint esse. Labore odio, architecto nihil quaerat soluta blanditiis impedit laudantium esse officiis dolorum dolore libero, id sequi minima incidunt eum facilis itaque distinctio. Voluptas doloremque minus reiciendis ex beatae laudantium cum sequi repellat blanditiis molestiae. Cumque, libero nulla! Sit, quisquam magni dolore consectetur odio impedit adipisci voluptas ab, laboriosam autem nihil nam est ipsa excepturi obcaecati eos neque! Omnis similique qui veritatis. Repellat magni dolorem, facilis eaque, harum molestias, delectus est adipisci laudantium velit optio blanditiis debitis? Tenetur totam maiores animi officiis eligendi expedita nemo corrupti distinctio. Cum libero soluta beatae doloribus sit, repellendus nobis vel obcaecati velit dolorem voluptate magnam inventore quas pariatur quam reprehenderit molestiae hic sunt dicta illo amet quis magni accusamus sequi? Vel quis, dolores iusto suscipit excepturi laboriosam repellat consectetur! Maiores deserunt, pariatur nesciunt consequuntur recusandae minima assumenda consequatur inventore natus debitis illo velit voluptatum necessitatibus qui aspernatur illum impedit magni dignissimos ea, molestias tempora corporis, asperiores iusto possimus. Libero expedita aspernatur officia totam dolorum culpa, minus, alias adipisci eligendi suscipit voluptates, magnam laudantium? Inventore cupiditate perspiciatis mollitia excepturi, voluptatibus ducimus expedita provident. Dicta, odit. Odio, qui repudiandae! Maiores dignissimos, magnam deleniti reprehenderit ex cum ea eveniet placeat quae, ad at perspiciatis nobis corporis doloribus voluptatem nulla aliquam sunt accusamus facere quaerat necessitatibus ipsa! Nam quisquam dicta minima commodi nostrum. Exercitationem necessitatibus optio cumque voluptate modi amet consequuntur similique ex inventore explicabo doloremque esse sed sequi nemo rem, nostrum ullam. Totam repellat ut ipsa quisquam rem, nulla, suscipit debitis atque earum quis voluptates quaerat exercitationem architecto repellendus placeat, tenetur incidunt distinctio consectetur reiciendis minima officiis aliquam? Ipsum sequi hic officia iste a. Blanditiis, dicta! Eveniet molestias ut natus odio fugiat cum necessitatibus, architecto, quo a quisquam autem porro explicabo ipsam, nostrum deserunt possimus expedita eum est corporis quibusdam cupiditate! Fugiat, quaerat saepe. Harum modi eligendi beatae alias fugiat. Nostrum cum nisi saepe dicta iste cupiditate, deserunt omnis, doloremque a distinctio eum rem adipisci ab? Sapiente, dicta ipsam blanditiis earum omnis necessitatibus temporibus, excepturi accusantium delectus quo quod iusto ad aliquam nemo ducimus ab nobis inventore sequi veritatis? Nulla, dolorem. Voluptas, obcaecati non facilis repellendus ratione officiis veritatis, modi culpa rerum placeat voluptatum quia ex? Officia quos dolorum repellat deserunt voluptas praesentium.</p>
        </div>
      </main> -->

</body>

</html>