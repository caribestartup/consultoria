@extends('default')

@section('title')

@endsection

@section('css')



@endsection

@section('content-chatbot')
    <div class="row orange-row  ">
        <div class="col-md-2 col-md-offset-2 d-flex align-items-center d-flex justify-content-end">
            <a  href="{{'chatbot/create' }}" class="btn btn-app-primary  border-bot ">Simular</a>
        </div>
        <div class="col-md-2 col-md-offset-2 d-flex align-items-center">
            <div class="form-group search-image  " style="margin-top: 16px">
                <input class="search-text" type="search" placeholder="">
                <i class="fa fa-search fa-lg fa-fw"></i>

            </div>
        </div>





    </div>

 <div class="sidebar"  style="margin-left: -36px;height: 80%;margin-top: 80px;border-top-right-radius: 35px;border-bottom-right-radius: 35px;position: absolute; z-index: 1 ">
     <div class="sidebar-logo ">
          <span class="img-menu ">
            <img src="{{ asset("images/orange-play.png") }}" width="25px" height="25px">
        </span>
     </div>
     <ul class="sidebar-menu scrollable pos-r pos "  style="position: absolute; z-index: -1">
        <li class="nav-item border">
            <input type="hidden" onclick="showtext()">
            <a class="sidebar-link"  >
        <span class="img-menu">
            <img src="{{ asset("images/interaction-text.png") }}" width="35px" height="35px">
        </span>
                <span class="title  pL-20">Texto</span>
            </a>
        </li>
         <li class="nav-item border">
             <a class="sidebar-link" href="http://consulting.com/users">
        <span class="img-menu">
            <img src="{{ asset("images/interaction-image.png") }}" width="35px" height="35px">
        </span>
                 <span class="title  pL-20">Imagen</span>
             </a>
         </li>
         <li class="nav-item border">
             <a class="sidebar-link" href="http://consulting.com/users">
        <span class="img-menu">
            <img src="{{ asset("images/interaction.png") }}" width="35px" height="35px">
        </span>
                 <span class="title  pL-20">?</span>
             </a>
         </li>
         <li class="nav-item border">
             <a class="sidebar-link" href="http://consulting.com/users">
        <span class="img-menu">
            <img src="{{ asset("images/interaction-list.png") }}" width="35px" height="35px">
        </span>
                 <span class="title  pL-20">Lista</span>
             </a>
         </li>
     </ul>
 </div>
 <div class="row d-flex justify-content-end " style="margin-right: -38px">
     <div class="col-md-4 d-flex flex-column bg-white p-30" name="interaction" id="textInteraction" onclick="showtext()" style="border-top-left-radius: 35px;border-bottom-left-radius: 35px">
         <label class="mt-4">Nombre de la interaccion</label>
         <input type="text " class="light-brown" style="border-radius: 35px">
         <label>Text</label>
         <textarea class="light-brown" style="border-radius: 35px"></textarea>
     </div>

     <div class="col-md-4 d-flex flex-column bg-white p-30" name="interaction" id="imageInteraction" onclick="showimage()" style="border-top-left-radius: 35px;border-bottom-left-radius: 35px">
         <label class="mt-4">Nombre de la interaccion</label>
         <input type="text " class="light-brown" style="border-radius: 35px">
         <label>Image</label>
         <textarea class="light-brown" style="border-radius: 35px"></textarea>
     </div>

     <div class="col-md-4 d-flex flex-column bg-white p-30" name="interaction" id="Interaction"  onclick="showinteraction()" style="border-top-left-radius: 35px;border-bottom-left-radius: 35px">
         <label class="mt-4">Nombre de la interaccion</label>
         <input type="text " class="light-brown" style="border-radius: 35px">
         <label>Interaction</label>
         <textarea class="light-brown" style="border-radius: 35px"></textarea>
     </div>

     <div class="col-md-4 d-flex flex-column bg-white p-30" name="interaction" id="listInteraction" onclick="showlist()" style="border-top-left-radius: 35px;border-bottom-left-radius: 35px">
         <label class="mt-4">Nombre de la interaccion</label>
         <input type="text " name="interaction" class="light-brown" style="border-radius: 35px">
         <label>List</label>
         <textarea class="light-brown" style="border-radius: 35px"></textarea>
     </div>
 </div>


@endsection

@section('js')
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script>
        function showtext(){
            $("input[name='interaction']").click(function () {

                $("#textInteraction").show();
                $("#imageInteraction").hide();
                $("#Interaction").hide();
                $("#listInteraction").hide();
            });
        }

        function showimage(){
            $("div[name='interaction']").click(function () {

                $("#textInteraction").hide();
                $("#imageInteraction").show();
                $("#Interaction").hide();
                $("#listInteraction").hide();
            });
        }

        function showinteraction(){
            $("div[name='interaction']").click(function () {

                $("#textInteraction").hide();
                $("#imageInteraction").hide();
                $("#Interaction").show();
                $("#listInteraction").hide();
            });
        }

        function showlist(){
            $("div[name='interaction']").click(function () {

                $("#textInteraction").hide();
                $("#imageInteraction").hide();
                $("#Interaction").hide();
                $("#listInteraction").show();
            });
        }
    </script>


@endsection