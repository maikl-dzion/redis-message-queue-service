<?php


//$message1 = [
//   'category_id' => 1,
//   'username'    => "Maikl",
//   'content'     => '1 сообщение',
//   'created_at'   => '12.05.2022',
//];
//
//$message2 = [
//    'category_id' => 1,
//    'username'    => "Семен",
//    'content'     => '2 сообщение',
//    'created_at'   => '16.05.2022',
//];
//
//$message3 = [
//    'category_id' => 3,
//    'username'    => "Maikl",
//    'content'     => '3 сообщение',
//    'created_at'   => '15.05.2022',
//];
//
//
//require __DIR__ . '/vendor/autoload.php';
//
//use Dzion\MessageQueue\MessageQueueService;
//$redis = new MessageQueueService();
//
//$redis->setMessage($message1);
//$redis->setMessage($message2);
//$redis->setMessage($message3);
//
//echo 'Начало:' . $redis->getCountMessages() . "<br>";
//echo  print_r($redis->popMessage(), true) . "<br>";
//echo  print_r($redis->popMessage(), true) . "<br>";
//// echo  "<pre>" . print_r($redis->getMessagesList(), true) . "</pre><br>";
//echo 'Конец:' . $redis->getCountMessages() . "<br>";


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Message queue service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style></style>
</head>
<body>

<div id="vue-app" class="wrapper">

    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                        <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg">
                        <h2 style="color:white; font-size: 22px; font-weight: bold; margin-left: 20px;">Сервис сообщений</h2>
                    </div>
                    <div class="hidden sm:block sm:ml-6"></div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"></div>
            </div>
        </div>
    </nav>

    <div class="bg-white">
        <div>
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div>Количество сообщений в очереди : {{countInQueue}}</div>
                <section aria-labelledby="products-heading" class="pt-6 pb-24">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-8 gap-y-10">
                        <tweet-list/>
                    </div>
                </section>

            </main>
        </div>
    </div>

</div>

</body>

<script src="resource/app.js" type="application/javascript" ></script>

<script>
    const {createApp} = Vue;

    const GlobalMixin = {
        data() {
            return {
                apiUrl : 'http://my-framework/message-queue',
                categoryList: [],
                tweets: [],
                countInQueue: 0,
                categoryName: 'Все категории',
            }
        },

        created() {
            this.getCategories();
            this.getTweets();
            this.tweetsCountInQueue();
        },

        methods: {

            get(url, callback) {
                const apiUrl = this.apiUrl + url;
                axios.get(apiUrl).then((response) => {
                    callback(response.data)
                }).catch((error) => {
                    console.log(error);
                })
            },

            post(url, postData, callback) {
                const apiUrl = this.apiUrl + url;
                axios.post(apiUrl, postData).then((response) => {
                    callback(response.data)
                }).catch((error) => {
                    console.log(error);
                });
            },

            getCategories() {
                const url = '/src/producer.php?action=get-categories';
                this.get(url, (response) => {
                    this.categoryList = response;
                });
            },

            getTweets() {
                this.categoryName = 'Все категории';
                const url = '/src/producer.php?action=get-tweets';
                this.get(url, (response) => {
                    this.tweets = response;
                });
            },

            tweetsCountInQueue() {
                const url = '/src/producer.php?action=tweets-count-in-queue';
                this.get(url, (response) => {
                    this.countInQueue = response['tweet_count'];
                });
            },

            selectTweets(category) {

                this.categoryName = category.title;
                let catId = parseInt(category.id);

                const url = '/src/producer.php?action=get-tweets';
                this.get(url, (response) => {
                    if(!catId) {
                        this.tweets = response;
                        return true;
                    }

                    let list = [];
                    for(let i in response) {
                        let elem = response[i];
                        if(parseInt(elem.category_id) == catId)
                            list.push(elem);
                    }

                    this.tweets = list;
                });
            },

        }
    }

    const App = createApp({

        data() {
            return {
                message: 'Hello Vue!'
            }
        },

        mounted() {
            let timerId = setInterval(() => {
                this.tweetsCountInQueue();
                // this.getTweets();
            }, 1000);
        },

    });

    App.mixin(GlobalMixin);
    App.component('tweet-form', TweetForm);
    App.component('tweet-list', TweetList);
    App.mount('#vue-app');

</script>

</html>





