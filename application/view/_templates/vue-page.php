    <div id="app">
        <v-app id="inspire" :dark="dark">
            <v-navigation-drawer v-model="drawer" fixed cliipped app>
                <v-list dense>
                    <v-list-tile v-for="item in menu" :key="item.text" @click.native="go(item.href,$event)">
                        <v-list-tile-content>
                            <v-list-tile-title>{{item.text}}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-navigation-drawer>
            <v-toolbar color="indigo" dense fixed cliipped-left app>
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>                    
                <v-toolbar-title class="align-center">
                    <span class="title" @click="go('',$event)">{{title}}</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn flat @click.native="go('user/panel',$event)"><v-icon>person</v-icon> <?php echo (Session::userIsLoggedIn() ? Session::get('user_email') : 'Login/Register');?></v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-content>
                <!-- page content here -->
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
                menu:[
                    {text:"Species",href:"species"},
                    {text:"Varieties",href:"varieties"},
                    {text:"Users",href:"users"},
                ]
            }),
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
                }
            }
        })
    </script>