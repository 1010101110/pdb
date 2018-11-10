<div id="app">
    <v-app id="inspire" :dark="dark">
        <v-navigation-drawer v-model="drawer" fixed cliipped app>
            <v-list dense>
                <v-list-tile v-for="item in menu" :key="item.text" @click="go(item.href,$event)" class="clickable">
                    <v-list-tile-content>
                        <v-list-tile-title>{{item.text}}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                    <v-list-tile-content>
                        <v-switch label="dark mode" v-model="dark"></v-switch>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar color="indigo" dark dense fixed cliipped-left app>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title class="align-center">
                <span class="title clickable" @click="go('',$event)">{{title}}</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn flat @click="go('user/panel',$event)"><v-icon>person</v-icon> <?php echo (Session::userIsLoggedIn() ? Session::get('user_email') : 'Login/Register');?></v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-content>
            <v-layout row wrap justify-center>
                <v-flex xs12 class="text-xs-center">
                    <h2>Welcome</h2>
                    <p>
                        Pepper database is a community maintained pepper reference.<br><br>
                        Have you grown or eaten any peppers lately? <br>
                        Add your images, reviews, data!
                    </p>
                </v-flex>

                <v-flex xs12>
                    <v-text-field prepend-icon="search" placeholder="Search..." v-model="search">
                </v-flex>

                <v-flex xs12 sm6 class="text-xs-center">
                    <v-img src="https://pepperdatabase.org/images/species/xCKYOYP.jpg" max-height="360" @click.native="go('variety',$event)" class="ma-3 elevation-3 clickable">
                        <span class="display-3 white--text">Varieties</span>
                        <div class="fill-height bottom-gradient"></div>
                    </v-img>
                </v-flex>

                <v-flex xs12 sm6 class="text-xs-center">
                    <v-img src="https://pepperdatabase.org/images/species/13.jpg" max-height="360" @click.native="go('species',$event)" class="ma-3 elevation-3 clickable">
                        <span class="display-3 white--text">Species</span>
                        <div class="fill-height bottom-gradient"></div>
                    </v-img>
                </v-flex>

                <v-flex xs12 sm6 class="pa-3">
                    <h3>Latest Reviews</h3>
                    <v-list>
                    <?php foreach($this->review as $rev){ ?>
                    <v-list-tile avatar ripple @click="go('variety/showVariety/' + '<?php echo $rev->variety; ?>' +'/#Reviews',$event)">
                        <v-list-tile-avatar>
                            <img src="<?php echo AvatarModel::getPublicUserAvatarFilePathByUserId($rev->created_by); ?>">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                <?php echo UserModel::getUserNameByID($rev->created_by) . " - " . VarietyModel::getVarietyName($rev->variety); ?>
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <?php } ?>
                    </v-list>
                </v-flex>

                <v-flex xs12 sm6 class="pa-3">
                    <h3><a href="https://pepperdatabase.org/history">Activity</a></h3>
                    <v-list>
                    <?php foreach($this->history as $his){ ?>
                    <v-list-tile avatar ripple @click="historylink('<?php echo $his->url;?>',$event)">
                        <v-list-tile-avatar>
                            <img src="<?php echo AvatarModel::getPublicUserAvatarFilePathByUserId($his->action_by); ?>">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                <?php echo UserModel::getUserNameByID($his->action_by) . " " . $his->action . " " . date("M d, Y",strtotime($his->action_on)); ?>
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <?php } ?>
                    </v-list>
                </v-flex>
            </v-layout>
        </v-content>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
<script>
    new Vue({
        el: '#app',
        data: () => ({
            title:"PepperDatabase",
            url:"<?php echo Config::get('URL'); ?>",
            drawer:false,
            dark:false,
            store:{},
            menu:[
                {text:"Species",href:"species"},
                {text:"Varieties",href:"varieties"},
                {text:"Users",href:"users"},
            ],
            search:""
        }),
        created: function(){
           this.store = window.localStorage
           this.dark = JSON.parse(this.store.getItem('dark'))
        },
        mounted: function(){
            document.body.style.opacity = "1"
        },
        watch: {
            dark:function(val,old){
                this.store.setItem('dark',this.dark)
            }
        },
        methods:{
            go: function(href,e){
                e.preventDefault()
                e.stopPropagation()

                if(e.which === 1){
                    window.location.href = this.url + href
                }

                if(e.which === 2){
                    window.open(this.url + href, '_blank')
                }
            },
            historylink: function(href,e){
                e.preventDefault()
                e.stopPropagation()

                if(e.which === 1){
                    window.location.href =  href
                }

                if(e.which === 2){
                    window.open(href, '_blank')
                }
            }
        }
    })
</script>