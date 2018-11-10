<div id="app">
    <v-app id="inspire" :dark="dark">
        <v-navigation-drawer v-model="drawer" fixed cliipped app>
            <v-list dense>
                <v-list-tile v-for="item in menu" :key="item.text" @click="go(item.href,$event)">
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
        <div class="pa-3">
            <?php if ($this->species) {?>
            <h2>
                {{species.name}}
                <v-tooltip>
                    <v-btn slot="activator" icon @click="edit($event)"> <v-icon>edit</v-icon> </v-btn>
                    <span>edit</span>
                </v-tooltip>
            </h2>

            <v-img height="400px" max-width="1000px" :src="url + 'images/species/' + species.ID + '.jpg'"></v-img>

            <h3>Identification</h3>
                {{species.attribute}}
            <h3>Description:</h3>
            <div id="description" class="mb-2">
                <span v-html="convert_description(species.description)"></span>
            </div>


            <v-data-table :headers="headers" :items="varieties" hide-actions>
                <template slot="items" slot-scope="props">
                    <td> <v-img height="150" width="150" :src="url + 'images/variety/' + props.item.ID + '/' + props.item.ID + '.jpg'"></v-img> </td>
                    <td> <a :href="url + 'variety/show/' + name_to_url(props.item.name)" class="display-1">{{ props.item.name }}</a></td>
                    <td>{{ props.item.heat }}</td>
                </template>
            </v-data-table>
            <?php } else { ?>
                <h2>Species not found...</h2>
            <?php } ?>
        </div>
        </v-content>

        <v-snackbar color="indigo" dark v-model="snackbar">{{snacktext}}</v-snackbar>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
<script>
    new Vue({
        el: '#app',
        data: () => ({
            title:"<?php echo $this->species->name; ?> : PepperDatabase",
            url:"<?php echo Config::get('URL'); ?>",
            drawer:false,
            dark:false,
            store:{},
            menu:[
                {text:"Species",href:"species"},
                {text:"Varieties",href:"varieties"},
                {text:"Users",href:"users"},
            ],
            headers:[
                { text: 'image', value: 'image', sortable : false },
                { text: 'name', value: 'name' },
                { text: 'heat', value: 'heat' },
            ],
            snackbar:false,
            snacktext:"",
            user: JSON.parse('<?php echo json_encode(Session::get('user')); ?>'),
            species: JSON.parse('<?php echo json_encode($this->species); ?>'),
            varieties: JSON.parse(`<?php echo json_encode($this->varieties); ?>`)
        }),
        created: function(){
           this.store = window.localStorage
           this.dark = JSON.parse(this.store.getItem('dark'))
        },
        mounted: function(){
            document.body.style.opacity = "1"
        },
        watch: {
            dark: function(val,old){
                this.store.setItem('dark',this.dark)
            }
        },
        methods: {
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
            name_to_url: function(name){
                return name.replace(/ /g,"-").toLowerCase()
            },
            convert_description: function(desc) {
                return decodeURIComponent(escape(atob(desc)));
            },
            edit: function(e){
                if(!this.user){
                    this.snacktext = "you must be logged in to do that"
                    this.snackbar = true
                }else{
                    go('species/editSpecies/' + this.species.ID,e)
                }
            }
        }
    })
</script>