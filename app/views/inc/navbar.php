
<?php

    // any navigation item for porject button can be incremented here
    $navitem = [
        'UML-Case-Diagram',
        'UML-Sequence-Diagram',
        'UML-Class-Diagram',
        'Activity-Diagram',
        'ERD'
    ];

    //LHS --> Controller name
    //RHS --> Nav display Name
    $loginNavItem =[
        
        'homePage'       =>  'home',
        'courseGuide'    =>  'course guide',
        'faculties'      =>  'faculty',
        'advisings' => 'advising panel',
        'grades'         =>  'grade sheet'
    ];
?>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
        <button 
            class="navbar-toggler" type="button" 
            data-toggle="collapse" data-target="#navbarsExampleDefault" 
            aria-controls="navbarsExampleDefault" aria-expanded="false" 
            aria-label="Toggle navigation">
            
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT.'/pages/about';?>">About</a>
                </li>
                <li class="nav-item dropdown">
                   
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Explore</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <?php foreach ($loginNavItem as $key => $value):?>
                            <a class="dropdown-item" href="<?php echo URLROOT.'/'.$key;?>"><?php echo ucwords($value); ?></a>
                        <?php endforeach; ?>
                    </div>

                <?php else : ?>
                    
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Project</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown02">
                        <?php foreach ($navitem as $value):?>
                            <a class="dropdown-item" href="#"><?php echo $value ?></a>
                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
               <?php if (isset($_SESSION['user_id'])) : ?>
                     
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo URLROOT;?>"><?php echo $_SESSION['user_id'];?></a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT;?>/users/logout">logout</a>
                    </li>
                    
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT;?>/users/signUp">Sign Up</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT;?>/users/login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>