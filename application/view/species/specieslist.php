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
            <h2>
                Species
                <v-tooltip>
                    <v-btn slot="activator" icon @click="go('species/add',$event)"> <v-icon>add</v-icon> </v-btn>
                    <span>Add New Species</span>
                </v-tooltip>
            </h2>

            <v-data-table :headers="headers" :items="species" hide-actions>
                <template slot="items" slot-scope="props">
                    <td> <v-img height="150" width="150" :src="url + 'images/species/' + props.item.ID + '.jpg'"></v-img> </td>
                    <td> <a :href="url + 'species/show/' + name_to_url(props.item.name)" class="display-1">{{ props.item.name }}</a></td>
                    <td>{{ props.item.attribute }}</td>
                </template>
            </v-data-table>
        </div>
        </v-content>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
<script>
    new Vue({
        el: '#app',
        data: () => ({
            title:"Species : PepperDatabase",
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
                { text: 'identification', value: 'attribute' },
            ],
            species: JSON.parse('<?php echo json_encode($this->species); ?>')
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
            }
        }
    })
</script>