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

    .modal-header{
        background-color: orange;
        color: white;
    }
    .modal-body{
            background-color: rgba(204, 204, 204, 0.58);
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
                                <div id = "mbs">
                                    
                                </div>
                            <!--Insert all the errors here-->
                            <!---if there are no errors, then add a success message -->
                            
                            <div class="alert alert-danger" v-if="errors.length != 0">
                                <div class="row" v-for="error in errors">
                                    {{ error|json }}
                                </div>
                            </div>
                              <form id="sportsform" method="POST" @submit.prevent="submitForm">
                              <input id="sportid" type="hidden" name="sport">
                            <!--submit this form to /dashboard/teams/register.php with a POST request(using ajax method) -->
<!-- <<<<<<< HEAD
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

                                <div>
                                </div>
                                <div id="members"></div>
======= -->
							  	<div class="form-group">
							  		<label class="control-label">
							  		Team Name:
							  		</label>
							  		<input v-model="teamname" class="form-control" type="text" placeholder="Team Name" name="teamname">
							  	</div>
							  
							  	<div class="form-group">
							  		<searchbox :members.sync="members"></searchbox>
							  	</div>
							  	<h3>Members added:</h3>
							  	<div>
							  	</div>
							  	<div id="members"></div>
                                <div class="form-group">
                                    <label class="control-label">Ambassador ID(optional)</label>
                                    <div class = "row">
                                        <div class  = "col-md-4" >
                                    <input class="form-control" type="text" placeholder="Ambassador ID(optional)" v-model="ambassador_id" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ambassador ID(optional)'"  name="ambassador_id">
                                    </div>
                                    </div>
                                
                                </div>  
                                <button class= "btn btn-success" type="submit">Apply</button>
							  </form>
							</div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						  </div>
						  
						</div>
					  </div>
    <div class="td-preloading">
        <span class="fa fa-spinner fa-spin"></span>
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
                                <h4 style="text-align:left;">Select a Event</h4>
                                <br>
								<br>
                                <!--new -->
                                <div class="row">
                                <div v-if="success" class="alert alert-success">
                                    Congratulations! Team registration successful!
                                </div>
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
                                            <input type="button" id="6" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" style = "padding-left:0;padding-right:0;"value="TableTennis(Female)"
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
                                            <input type="button" id="11" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="COD 4: MW"
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
                                            <input type="button" id="13" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Make it Right"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="14" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="DOTA 2"
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
                                            <input type="button" id="18" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Crimeline Road"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="button" id="19" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Mathletics"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="20" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Egg Rover Mission"
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
                                            <input type="button" id="22" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Funkaar"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="23" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Pakistan Got Talent"
                                            />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" id="24" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Paintball"
                                            />
                                        </div>
                                    </div>
                                    <br>

                                     <div class="row">
                                        <div class="col-md-6">
                                            <input type="button" id="25" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Minute to win it (Team)"/>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="button" id="26" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" style="padding-left:0;padding-right:0;" value="Speed Programming"/>
                                        </div>
                                         
                                        
                                    </div>
                                    <br>

                                     <div class="row">
                                        
                                       
                                         <div class="col-md-6 col-md-offset-3">
                                            <input type="button" id="27" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" style="padding-left:0;padding-right:0;" value="Virtual Stock Simulator"/>
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
            <script src="/js/responsive.js"></script>
            <script src="/js/perfect-scrollbar.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>         
            <script src="/js/jquery.visible.min.js"></script>
            <script src="/js/scriptdemo3.js"></script>
            <script src="/js/classie.js"></script>
            <script src="/js/detectanimation.js"></script>
            <script src="/js/modernizr.custom.js"></script>
    <template id="searchbox">
        <label for="SearchTeamId" class="control-label">
        Add a team member:
        </label>
        <input type="text" v-model="term" placeholder="User ID" class="form-control" id="SearchTeamId">
        <button id="SearchBtn" @click.prevent="search">Search</button>
        <button v-if="(addedMyself == 0)" @click.prevent="addYourself">Add Yourself!</button>
        <div v-if="result.Cnic">
            {{ result.Cnic }} - {{ result.Firstname }} {{ result.Lastname }}
            <button @click.prevent="add">add</button>
        </div>
        <div v-if="noresult">
            Participant ID not found!
        </div>
        <hr>
        Members Added:
        <div v-if="addedMyself == 0" class="alert alert-warning">You haven't added yourself(not required)</div>
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
            noresult: false,
            addedMyself: 0

        };},
        props: ['members'],
        methods: {
            addYourself: function(){
                this.members.push(
                    {
                        Participantid: "<?=$auth->getParticipant()->getParticipantID()?>",
                        Cnic: "<?=$auth->getParticipant()->getCnic()?>",
                        Firstname: "<?=$auth->getParticipant()->getFirstname()?>",
                        Lastname: "<?=$auth->getParticipant()->getLastname()?>"
                        }
                );
                this.addedMyself = 1;
            },
            search(){
                this.$http.post('/dashboard/search.php', {'id': this.term}).then((response)=>{
                    console.log(this.result = JSON.parse(response.body));
                    console.log(this.result.Participantid);
                    this.noresult = 0;
                }, (response)=>{
                    this.noresult = 1;
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
                    if(this.members[i].Participantid == "<?=$auth->getParticipant()->getParticipantID()?>" ){
                        this.addedMyself = 0;
                    }
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
            success:0,
        },
        methods:{

            resetForm: function(){
                console.log("cleared");
                this.members = [];
                this.teamname = null;
                this.ambassador_id = null;
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
                    if(response.body == "1"){
                        this.success = 1;
                        $("#myModal").modal('toggle');
                    }
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
        teamEvent = ["none","Volleyball(Male)","Volleyball(Female)","Basketball(Male)","Basketball(Female)",
        "Table Tennis(Male)","Table Tennis(Female)","Badminton(Male)","Badminton(Female)",
        "Cricket","FootyMania","Call of Duty: Modern Warfare","Counter Strike 1.6",
        "Make it Right","DOTA 2","Bait Bazi","Capture The Flag","Human Foosball",
        "The Crimeline Road","Mathletics","The Egg Rover Mission","Olympiad Feud","Funkaar",
        "Pakistan Got Talent", "Paintball","Minute to win it(team)","Speed Programming",
        "Virtual Stock Simulator"];

       

var infoTeam = ["NONE","Event Fee: Rs. 3500 <br>Minimun Participants: 5 <br> Max. Participants: 7 <br><br><a style = 'color: blue' href ='../../events/sports/volleyball.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 2500 <br>Minimun Participants: 5 <br> Max. Participants: 7 <br><br><a style = 'color: blue' href ='../../events/sports/volleyball.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 4000 <br>Minimun Participants: 5 <br> Max. Participants: 7 <br><br><a style = 'color: blue' href ='../../events/sports/basketball.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 3500 <br>Minimun Participants: 5 <br> Max. Participants: 7 <br><br><a style = 'color: blue' href ='../../events/sports/basketball.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 1000 <br>Minimun Participants: 2 <br> Max. Participants: 2 <br><br><a style = 'color: blue' href ='../../events/sports/table-tennis.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 800 <br>Minimun Participants: 2 <br> Max. Participants: 2 <br><br><a style = 'color: blue' href ='../../events/sports/table-tennis.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 2000 <br>Minimun Participants: 2 <br> Max. Participants: 2 <br><br><a style = 'color: blue' href ='../../events/sports/badminton.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 1600 <br>Minimun Participants: 2 <br> Max. Participants: 2 <br><br><a style = 'color: blue' href ='../../events/sports/badminton.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 6000 <br>Minimun Participants: 11 <br> Max. Participants:13 <br><br><a style = 'color: blue' href ='../../events/sports/cricket.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 4000 <br>Minimun Participants: 5 <br> Max. Participants: 9 <br><br><a style = 'color: blue' href ='../../events/sports/footy-mania.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 2500 <br>Minimun Participants: 5 <br> Max. Participants: 5 <br><br><a style = 'color: blue' href ='../../events/all-events/e-gaming.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 2500 <br>Minimun Participants: 5 <br> Max. Participants: 5 <br><br><a style = 'color: blue' href ='../../events/all-events/e-gaming.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 800 <br>Minimun Participants: 5 <br> Max. Participants: 5 <br><br><a style = 'color: blue' href ='../../events/events.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 2500 <br>Minimun Participants: 5 <br> Max. Participants: 5 <br><br><a style = 'color: blue' href ='../../events/all-events/e-gaming.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 400 <br>Minimun Participants: 1 <br> Max. Participants: 2 <br><br><a style = 'color: blue' href ='../../events/all-events/bait-bazi.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 1500 <br>Minimun Participants: 7 <br> Max. Participants:10 <br><br><a style = 'color: blue' href ='../../events/all-events/capture-the-flag.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 2500 <br>Minimun Participants: 5 <br> Max. Participants: 7 <br><br><a style = 'color: blue' href ='../../events/all-events/human-foosball.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 1500 <br>Minimun Participants: 2 <br> Max. Participants: 3 <br><br><a style = 'color: blue' href ='../../events/all-events/crimeline.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 1200 <br>Minimun Participants: 2 <br> Max. Participants: 3 <br><br><a style = 'color: blue' href ='../../events/all-events/matheletics.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 1200 <br>Minimun Participants: 2 <br> Max. Participants: 3 <br><br><a style = 'color: blue' href ='../../events/all-events/egg-rover.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 1500 <br>Minimun Participants: 3 <br> Max. Participants: 5 <br><br><a style = 'color: blue' href ='../../events/all-events/olympiad-feud.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 500 <br>Minimun Participants: 1 <br> Max. Participants: 3 <br><br><a style = 'color: blue' href ='../../events/all-events/funkaar.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 4000 <br>Minimun Participants: 3 <br> Max. Participants: 5 <br><br><a style = 'color: blue' href ='../../events/all-events/pak-got-talent.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 5000 <br>Minimun Participants: 5 <br> Max. Participants: 5 <br><br><a style = 'color: blue' href ='../../events/all-events/paintball.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 500 <br>Minimun Participants: 1 <br> Max. Participants: 3 <br><br><a style = 'color: blue' href ='../../events/all-events/minute-to-win-it.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 2500 <br>Minimun Participants: 2 <br> Max. Participants: 5<br><br><a style = 'color: blue' href ='../../events/all-events/speedprogramming.html' target = '_blank'>View Event Details and Rules</a><br><br>",
       "Event Fee: Rs. 800 <br>Minimun Participants: 5 <br> Max. Participants: 5<br><br><a style = 'color: blue' href ='../../events/events.html' target = '_blank'>View Event Details and Rules</a><br><br>"

       
       
       ];
// end


        
$(document).on("click", ".my-btn", function () {
            var id = $(this).attr('id');
            window.$vm.sportid = id;
            $(".modal-title").html('Register for ' +teamEvent[id]);
             $("#mbs").html(infoTeam[id]);
        
        });
    });
    </script>
</body>

</html>