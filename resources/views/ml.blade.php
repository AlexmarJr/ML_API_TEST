<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mercado quase livre</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>
    <style>
        a{
          color: black;
          text-decoration: none;
        }
        .litle_a{
            font-size: 11px
        }
        .big_a{
            font-size: 15px;
            font-weight: bold;
            width: 100%
        }
    </style>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-sm navbar-light bg-light">
                <a class="navbar-brand" href="#">Mercado Quase Livre</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse float-right" id="navbarSupportedContent">
                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="getMLData()">Sincronizar Dados com API</button>
                </div>

                <div class="collapse navbar-collapse float-right" id="navbarSupportedContent">
                    <form action="">
                        <a class="btn btn-outline-danger my-2 my-sm-0" href="{{ route('wipe_api_data') }}">Limpar Dados da API</a>
                    </form>
                </div>
            </nav>
              
            <hr>
            @foreach ($data as $datinha)
                <div class="row">
                    <a href="#" onclick="openCategory('{{$datinha->id}}')"  class="big_a">{{ $datinha->name }}</a>
                    <br>
                    @foreach (json_decode($datinha->children_categories, true) as $children)
                        <div class="col-4" >
                            <a href="#" onclick="openCategory('{{$children['id']}}')" class="litle_a">{{ $children['name'] }}</a> <br>
                        </div>
                    @endforeach
                    <br>
                </div>
            @endforeach
        </div>


        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id='dinoModal' data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="container">
                        <h5 id='infoLoad'>Aguarde a Syncronização com a API do Mercado Livre <br> Sinta-se avontade pra jogar o jogo do dinousaro(Sem o Dinosauro)</h5>
                        <iframe src="https://giphy.com/embed/dJGYFScvBjfRabiH7m" width="350" height="160" frameBorder="0" class="giphy-embed" allowFullScreen style="display:block" id='loading'></iframe>
                        <iframe src="https://giphy.com/embed/8UF0EXzsc0Ckg" width="350" height="160" frameBorder="0" class="giphy-embed" allowFullScreen style="display:none" id='done'></iframe>
                    </div>
                    <canvas id="game" width="640" height="400"></canvas>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalhes do <b id='title'></b> <img src="" id='src_img' style="width: 20%"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <h6>Eu nao entendi muito oque é pra fazer nessa parte aqui, nao vi nada sobre puxar esses dados da API do mercado livre, entao so vou trazer os detalhes disso ai</h6>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon3">Nome: </span>
                                    </div>
                                    <input type="text" class="form-control" id="name" aria-describedby="basic-addon3" disabled>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon3">Criação: </span>
                                    </div>
                                    <input type="text" class="form-control" id="created" aria-describedby="basic-addon3" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
            </div>
        </div>
    </body>

    <script>
        function getMLData(){
            $('#dinoModal').modal('show');
            $('#dinoModal').modal({backdrop: 'static', keyboard: false})
            dino();
            let q = $('#search').val()
            $.ajax({
                url:"/load-data",
                type: "get",
                dataType: 'json',
                    success: function (response) {
                        $("#loading").css("display", "none");   
                        $("#done").css("display", "block");   
                        $("#infoLoad").text('Sua sincronização esta completa, atualize a pagina quando quiser(Pra nao estragar seu jogo)')
                    }
            })
        }

        function openCategory(id){
            $.ajax({
                url:"/details/" + id,
                type: "get",
                dataType: 'json',
                    success: function (response) {
                        $("#name").val(response.name)
                        $("#created").val(response.date_created);
                        $("#src_img").attr('src', response.picture)
                        $('#details').modal('show');
                        $("#title").text(response.id);
                    }
            })
        }

        function dino(){
            const canvas = document.getElementById('game');
            const ctx = canvas.getContext('2d');

            // Variables
            let score;
            let scoreText;
            let highscore;
            let highscoreText;
            let player;
            let gravity;
            let obstacles = [];
            let gameSpeed;
            let keys = {};

            // Event Listeners
            document.addEventListener('keydown', function (evt) {
            keys[evt.code] = true;
            });
            document.addEventListener('keyup', function (evt) {
            keys[evt.code] = false;
            });

            class Player {
            constructor (x, y, w, h, c) {
                this.x = x;
                this.y = y;
                this.w = w;
                this.h = h;
                this.c = c;

                this.dy = 0;
                this.jumpForce = 15;
                this.originalHeight = h;
                this.grounded = false;
                this.jumpTimer = 0;
            }

            Animate () {
                // Jump
                if (keys['Space'] || keys['KeyW']) {
                this.Jump();
                } else {
                this.jumpTimer = 0;
                }

                if (keys['ShiftLeft'] || keys['KeyS']) {
                this.h = this.originalHeight / 2;
                } else {
                this.h = this.originalHeight;
                }

                this.y += this.dy;

                // Gravity
                if (this.y + this.h < canvas.height) {
                this.dy += gravity;
                this.grounded = false;
                } else {
                this.dy = 0;
                this.grounded = true;
                this.y = canvas.height - this.h;
                }

                this.Draw();
            }

            Jump () {
                if (this.grounded && this.jumpTimer == 0) {
                this.jumpTimer = 1;
                this.dy = -this.jumpForce;
                } else if (this.jumpTimer > 0 && this.jumpTimer < 15) {
                this.jumpTimer++;
                this.dy = -this.jumpForce - (this.jumpTimer / 50);
                }
            }

            Draw () {
                ctx.beginPath();
                ctx.fillStyle = this.c;
                ctx.fillRect(this.x, this.y, this.w, this.h);
                ctx.closePath();
            }
            }

            class Obstacle {
            constructor (x, y, w, h, c) {
                this.x = x;
                this.y = y;
                this.w = w;
                this.h = h;
                this.c = c;

                this.dx = -gameSpeed;
            }

            Update () {
                this.x += this.dx;
                this.Draw();
                this.dx = -gameSpeed;
            }

            Draw () {
                ctx.beginPath();
                ctx.fillStyle = this.c;
                ctx.fillRect(this.x, this.y, this.w, this.h);
                ctx.closePath();
            }
            }

            class Text {
            constructor (t, x, y, a, c, s) {
                this.t = t;
                this.x = x;
                this.y = y;
                this.a = a;
                this.c = c;
                this.s = s;
            }

            Draw () {
                ctx.beginPath();
                ctx.fillStyle = this.c;
                ctx.font = this.s + "px sans-serif";
                ctx.textAlign = this.a;
                ctx.fillText(this.t, this.x, this.y);
                ctx.closePath();
            }
            }

            // Game Functions
            function SpawnObstacle () {
            let size = RandomIntInRange(20, 70);
            let type = RandomIntInRange(0, 1);
            let obstacle = new Obstacle(canvas.width + size, canvas.height - size, size, size, '#2484E4');

            if (type == 1) {
                obstacle.y -= player.originalHeight - 10;
            }
            obstacles.push(obstacle);
            }


            function RandomIntInRange (min, max) {
            return Math.round(Math.random() * (max - min) + min);
            }

            function Start () {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            ctx.font = "20px sans-serif";

            gameSpeed = 3;
            gravity = 1;

            score = 0;
            highscore = 0;
            if (localStorage.getItem('highscore')) {
                highscore = localStorage.getItem('highscore');
            }

            player = new Player(25, 0, 50, 50, '#FF5858');

            scoreText = new Text("Score: " + score, 25, 25, "left", "#212121", "20");
            highscoreText = new Text("Highscore: " + highscore, canvas.width - 25, 25, "right", "#212121", "20");

            requestAnimationFrame(Update);
            }

            let initialSpawnTimer = 200;
            let spawnTimer = initialSpawnTimer;
            function Update () {
            requestAnimationFrame(Update);
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            spawnTimer--;
            if (spawnTimer <= 0) {
                SpawnObstacle();
                console.log(obstacles);
                spawnTimer = initialSpawnTimer - gameSpeed * 8;
                
                if (spawnTimer < 60) {
                spawnTimer = 60;
                }
            }

            // Spawn Enemies
            for (let i = 0; i < obstacles.length; i++) {
                let o = obstacles[i];

                if (o.x + o.w < 0) {
                obstacles.splice(i, 1);
                }

                if (
                player.x < o.x + o.w &&
                player.x + player.w > o.x &&
                player.y < o.y + o.h &&
                player.y + player.h > o.y
                ) {
                obstacles = [];
                score = 0;
                spawnTimer = initialSpawnTimer;
                gameSpeed = 3;
                window.localStorage.setItem('highscore', highscore);
                }

                o.Update();
            }

            player.Animate();

            score++;
            scoreText.t = "Score: " + score;
            scoreText.Draw();

            if (score > highscore) {
                highscore = score;
                highscoreText.t = "Highscore: " + highscore;
            }
            
            highscoreText.Draw();

            gameSpeed += 0.003;
            }

            Start();
        }
    </script>
</html>
