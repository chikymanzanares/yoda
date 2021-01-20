<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <title>Yoda</title>
    <style>
        #app { margin-left: 300px; }
        li{ margin: 15px 0;}
    </style>
</head>

<body>
    <div id="app">
        <div id="history">
            <li v-for="intervention in interventions">
                <label>
                    <span><b><?php echo '{{intervention.speaker}}: ';?></b>
                        <span v-html="<?php echo 'intervention.text';?>"></span>
                    </span>
                </label>
                <ol v-for="alternative in intervention.alternatives">
                    <span><?php echo '{{alternative}}';?></span>
                </ol>
            </li>
        </div>
        <label for="message"></label>
        <span><?php echo '{{alert}}';?></span><br>
        <input type="text" id="message" name="message" v-model="message" size="50" @keyup.enter="submitReply">
        <button v-on:click="submitReply">Send!</button>
    </div>

    <script>
        var conversation = new Vue({
            el: '#app',
            data: {
                alert: '',
                message: '',
                interventions: [],
                alternatives:[
                ],
            },
            mounted() {
                //localStorage.setItem('history', '');
                if (localStorage.getItem('history')) this.interventions = JSON.parse(localStorage.getItem('history'));
            },
            methods: {
                submitReply: function (event) {
                    if (this.message === ''){
                        return;
                    }
                    this.alert = "YodaBot is writting...";
                    this.interventions.push(
                        {text: this.message, speaker: 'Me'}
                    );
                    let post = {
                        message: this.message
                    };
                    axios
                        .post('/api/reply',post)
                        .then((result) => {
                            const myObjStr = JSON.stringify(result.data);
                            const replyJSON = JSON.parse(myObjStr);
                            var replyBot;
                            if (replyJSON.secondNotFound){
                                replyBot = replyJSON.reply + ' But there is a list of Star Wars characters';
                            }
                            if (replyJSON.isForce){
                                replyBot = ('The <B>force</B> is in this movies:');
                            } else if (!(replyJSON.secondNotFound)){
                                replyBot = replyJSON.reply;
                            }
                            this.interventions.push(
                                {text: replyBot, speaker: 'YodaBot', alternatives: replyJSON.alternativeReply}
                            );
                            localStorage.setItem('history', JSON.stringify(this.interventions));
                            console.log(localStorage.getItem('history'));
                            this.alert = '';
                            this.message = '';
                        })
                        .catch(error => console.log(error))
                }
            }
        })
    </script>
    </body>
</html>

