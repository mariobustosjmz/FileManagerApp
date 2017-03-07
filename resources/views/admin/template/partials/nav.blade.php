

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/admin/"><i class="glyphicon glyphicon-cloud
"></i> FileManagerApp Admin.<i class="glyphicon glyphicon-cloud"></i></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="/admin/">Home <span class="sr-only">(current)</span></a></li>
        <li><a href="/admin/folders">Folders</a></li>
        <li><a href="/admin/files">Files</a></li>
         <li><a href="/admin/ext">Extensions</a></li>
        <li><a href="/admin/logs">Logs</a></li>


      </ul>







              <ul class="nav navbar-nav navbar-right">
                      <li><a href="/">Front</a></li>

                  <!-- Authentication Links -->
                  @if (Auth::guest()) <!-- Validar seccion de codigo Si No esta logueado entonces -->


                  @else <!-- Validar seccion de codigo Si  esta logueado entonces -->
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false">
                              {{ Auth::user()->name }} <!--Traer el nombre del usuario logeado --> <span class="caret"></span>
                          </a>

                          <ul class="dropdown-menu" role="menu">
                                  <li><a href="">User ID :  {{ Auth::user()->id }} </a></li>
                                  <li><a href="/admin/users">Users</a></li>

                              <li>
                                  <a href="{{ url('/logout') }}"
                                      onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                      Logout
                                  </a>

                                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                      {{ csrf_field() }}
                                  </form>
                              </li>
                          </ul>
                      </li>
                  @endif
              </ul>





    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>