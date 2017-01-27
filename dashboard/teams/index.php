<?php 
namespace Dashboard;
require(__DIR__ . '/../../bootstrap.php');

use PDO;
use Model\Model\SportsQuery;
use Respect\Validation\Validator as v;

//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();
$auth->onlyVerified();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports | NUST Olympiad '17</title>
    <link rel="stylesheet" type="text/css" href="../css/timeline.css">
    <link rel="stylesheet" href="/css/themify-icons.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel='stylesheet' href='/css/perfect-scrollbar.min.css' />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/buttons.css" />
    <link rel="stylesheet" href="/css/animate.css" />
    <link rel="stylesheet" href="/css/tooltip.css" />
    <link rel="stylesheet" href="/css/demo3.css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="/css/style2.css" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Sports | NUST Olympiad '17</title>
    <script type="text/javascript" src="/js/jquery.min.js"></script>

    <style>
    a {
        color: white;
    }
    
    a:hover,
    a:focus {
        color: white;
    }
    
    input {
        color: white;
    }
    
    label {
        font-weight: normal;
    }
    
    .col-centered {
        float: none;
        margin: 0 auto;
    }
    
    .my-box {
        border-style: solid;
        border-color: white;
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-width: 1px;
        padding: 2%;
    }
    
    .my-btn {
        background-color: transparent;
        color: white;
        border-radius: 0 !important;
    }
    input
    {
        width: 80%;
        
    }
    </style>
</head>

<body id="id-body">
<!-- Modal -->
					  <div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
						
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Modal Header</h4>
							</div>
							<div class="modal-body">
                            <!--Insert all the errors here-->
                            <!---if there are no errors, then add a success message -->
                            <div v-if="success" class="alert alert-success">
                                Congratulations! Team registration successful!
                            </div>
                            <div class="alert alert-danger" v-if="errors.length != 0">
                                <div class="row" v-for="error in errors">
                                    {{ error|json }}
                                </div>
                            </div>
                              <form id="sportsform" method="POST" @submit.prevent="submitForm">
                              <input id="sportid" type="hidden" name="sport">
                            <!--submit this form to /dashboard/teams/register.php with a POST request(using ajax method) -->
							  	<div class="form-group">
							  		<label class="control-label">
							  		Team Name:
							  		</label>
							  		<input v-model="teamname" class="form-control" type="text" placeholder="Team Name" name="teamname">
							  	</div>
							  	<hr>
							  	<div class="form-group">
							  		<searchbox :members.sync="members"></searchbox>
							  	</div>
							  	<h3>Members added:</h3>
							  	<div>
							  	</div>
							  	<div id="members"></div>
                                <div class="form-group">
                                    <label class="control-label">Ambassador ID(optional)</label>
                                    <input class="form-control" type="text" placeholder="Ambassador ID(optional)" v-model="ambassador_id" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ambassador ID(optional)'"  name="ambassador_id">
                                </div>  
							  	<hr>
                                <button type="submit">Apply</button>
							  </form>
							</div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						  </div>
						  
						</div>
					  </div>
    <div class="td-preloading">
         <!-- <span class="fa fa-spinner fa-spin"></span> -->
		
			<canvas id="c" width="300px" height="300px" ></canvas>
			<img src="../../img/torch.png" widht="150px" height="150px" id="id-img-preload">
    </div>
    <div class="td-container">
        <!--<div class="row">
        <div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2  col-sm-4 col-sm-offset-4">
            <img src="../img/cube.png" alt="" style="margin-bottom:0;">
        </div>
    </div>-->
        <div class="td-sheets-container td-hide td-sheet-active-1">
            <div class="row">
            </div>
            <div id="scrollbar-container" class="td-sheet active">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 col-centered col-sm-3">
                           
                                <img src="/img/logo.png" class="img-responsive" alt="LOGO" />
                            
                        </div>
                    </div>
                    <div class="row homepage">

                    </div>
                    <div class="row">
                        <div class="col-md-10 col-xs-5 col-sm-7">
                            <a href="../">Back to Dashboard</a>
                        </div>
                        <div class="col-md-2 col-xs-7 col-sm-5">
                            <div id="userId">
                                <p style="display:inline;color:orange;">User Id:<?=$auth->getParticipant()->getParticipantID()?></p><span> | </span><a href="#">Logout</a></div>
                        </div>
                        <hr>
                    </div>
						
                    <div class="row">
                      <div class = "col-md-1"></div>
                            <div class="col-md-10 my-box ">
                            	<div class="row">
                            
                            	</div>
                                <h4 style="text-align:left;">Select a Team Event</h4>
                                <br>
								<br>
                                <!--new -->
                                <div class="row">
                                    <div class = "col-md-2 col-xs-3"></div>
									<div class = "col-md-8 col-xs-6">
									<center>
									<div class="row">
                                        <div class="col-md-4">
                                            <input type="button" id="1" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Volleyball(Male)"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="2" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Volleyball(Female)"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="3" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Basketball(Male)"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="button" id="4" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Basketball(Female)"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="5" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Table Tennis(Male)"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="6" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Table Tennis(Female)"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                     <div class="row">
                                        <div class="col-md-4">
                                            <input type="button" id="7" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Badminton(Male)"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="8" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Badminton(Female)"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="9" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Cricket"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="button" id="10" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="FootyMania"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="11" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="COD 4: Modern Warfare"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="12" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Counter Strike 1.6"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                     <div class="row">
                                     
                                        <div class="col-md-4">
                                            <input type="button" id="13" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="DOTA 2"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="14" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Paintball"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="15" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Bait Bazi"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="button" id="16" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Capture The Flag"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="17" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Human Foosball"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="18" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="The Crimeline Road"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="button" id="19" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Mathletics"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="20" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Egg Drop"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="21" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Olympiad Feud"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                      <div class="row">
                                        
                                        <div class="col-md-4">
                                            <input type="button" id="22" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Pakistan Got Talent"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="23" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Minute to win it(team)"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="24" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Funkaar"/>
                                        </div>
                                        

                                    </div>
                                    <br>

                                     <div class="row">
                                     
                                         <div class="col-md-4">
                                            <input type="button" id="25" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="100m Relay"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="26" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="200m Relay"
                                            />
                                        </div>
                                         
                                        
                                        
                                    </div>
                                    <br>
									</center>
									</div>
									<div class = "col-md-2 col-xs-3"></div>
                                </div>
                                <!--new-->
                            </div>
					  <div class = "col-md-1"></div>
                     
                    </div>
                    <br>
                    <br>

					
                    
                </div>
            </div>
			
					  
            <script src="/js/jquery.min.js"></script>
            <script type="text/javascript">
   		$(document).ready(function(){
   			function setPreLoadMargin(){
   				var width = $(window).width();
   				
   				$('#c').css({"position":"absolute","left":((width-300)/2)+"px"});
   				$('#id-img-preload').css({"position":"absolute","top":"50%","left":((width-95)/2)+"px"});
   			}
   			setPreLoadMargin();
   			$(window).resize(function(){setPreLoadMargin();});

   		});
   </script>
            <script src="/js/responsive.js"></script>
            <script src="/js/perfect-scrollbar.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>         
            <script src="/js/jquery.visible.min.js"></script>
            <script src="/js/scriptdemo3.js"></script>
            <script src="/js/classie.js"></script>
            <script src="/js/detectanimation.js"></script>
            <script src="/js/modernizr.custom.js"></script>
            <!-- preloading flame js-->
   <script type="text/javascript" src="../../js/flame.js"></script>
   
    <template id="searchbox">
        <label for="SearchTeamId" class="control-label">
        Add a team member:
        </label>
        <input type="text" v-model="term" placeholder="User ID" class="form-control" id="SearchTeamId">
        <button id="SearchBtn" @click.prevent="search">Search</button>
        <div v-if="result.Cnic">
            {{ result.Cnic }} - {{ result.Firstname }} {{ result.Lastname }}
            <button @click.prevent="add">add</button>
        </div>
        <hr>
        Members Added:
        <div v-for="member in members">
            {{ member.Cnic }} - {{ member.Firstname }} {{ member.Lastname }}
            <button @click.prevent="deletemember(member)">delete</button>
        </div>
    </template>
   <script src="/js/vue.js" ></script>
   <script src="/js/vue-resource.js" ></script>
   <script src="/js/lodash.core.min.js" ></script>
    <script>
    Vue.http.options.emulateJSON = true;
    Vue.component('searchbox',{
        template: '#searchbox',
        data: function(){return {
            term : '',
            result : {},
        };},
        props: ['members'],
        methods: {
            search(){
                this.$http.post('/dashboard/search.php', {'id': this.term}).then((response)=>{
                    console.log(this.result = JSON.parse(response.body));
                    console.log(this.result.Participantid);
                }, (response)=>{
                    console.log("error");
                });
            },
            add(){
                if(!_.includes(this.members, this.result)){

                    this.members.push(this.result);
                    console.log(this.members);
                }
                else{
                    console.log("already exists");
                }
            },
            deletemember(member){
                // console.log(member);
                var x;
                for(var i=0;i<this.members.length;i++){
                    if(this.members[i].Participantid == member.Participantid)
                        x=i;
                }

                this.members.splice(x,1);
            }
        }
    });
    window.$vm = new Vue({
        el : '#id-body',
        data: {
            members: [],
            teamname : null,
            ambassador_id : null,
            sportid: null,
            errors:[],
            success:0
        },
        methods:{
            resetForm: function(){
                console.log("cleared");
                this.members = [];
                this.teamname = null;
                this.ambassador_id = null;
                this.success = 0;
                this.errors = [];
            },
            submitForm: function(){
                var ids = [];
                for(member in this.members){
                    ids.push(this.members[member].Participantid);
                }
                var formdata = {
                    team_member_ids : ids,
                    teamname : this.teamname,
                    sport : this.sportid,
                    ambassador_id: this.ambassador_id
                }; 
                console.log(formdata);
                this.$http.post('/dashboard/teams/create.php', formdata).then((response)=>{
                    console.log(response);
                    if(response.body == "1")
                        this.success = 1;
                    else{
                        this.errors = JSON.parse(response.body);
                    } 
                }, (response)=>{
                    this.errors = [{'fatal':"Some error occured!"}];
                });
            }
        }
    });
    $('#myModal').on('hidden.bs.modal', function(){window.$vm.resetForm();});
    $(document).ready(function()
    {
         var teamEvent = ["none","Volleyball(Male)","Volleyball(Female)","Basketball(Male)","Basketball(Female)",
        "Table Tennis(Male)","Table Tennis(Female)","Badminton(Male)","Badminton(Female)",
        "Cricket","FootyMania","Call of Duty 4: Modern Warfare","Counter Strike 1.6",
        "DOTA 2","Paintball","Bait Bazi","Capture The Flag","Human Foosball",
        "The Crimeline Road","Mathletics","Egg Drop","Olympiad Feud",
        "Pakistan Got Talent","Minute to win it(team)","Funkaar","100m relay","200m relay"];

        $(".modal-title").html('Register for ' +teamEvent[0]);
        
        $(document).on("click", ".btn", function () {
            var id = $(this).attr('id');
            window.$vm.sportid = id;
            $(".modal-title").html('Register for ' +teamEvent[id]);
        });
    });
    </script>
</body>

</html>