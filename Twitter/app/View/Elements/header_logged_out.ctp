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
      <ul class="nav navbar-nav navbar-left">
        <li><a <?php  echo $this->HTML->link('Twitter',array(
                 'controller'=> 'tweets','action' => 'index'));
           ?></a></li>
      </ul>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

       <ul class="nav navbar-nav navbar-right">
        <li><a <?php  echo $this->HTML->link('Log in',array(
                 'controller'=> 'users','action' => 'login'));
           ?></a></li>
      </ul>
     
      <ul class="nav navbar-nav navbar-right">
        <li><a <?php  echo $this->HTML->link('Registration',array(
                 'controller'=> 'users','action' => 'register'));
           ?></a></li>
      </ul>
       <ul class="nav navbar-nav navbar-right">
        <li>
          <?php  echo $this->HTML->link('Home',array(
                 'controller'=> 'tweets','action' => 'index'));
           ?>  
      </li>
      </ul>
     
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
