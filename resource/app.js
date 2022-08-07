
const {createApp} = Vue;

const GlobalMixin = {
    data() {
        return {
            apiUrl : API_URL,
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

    mounted() {
        let timerId = setInterval(() => {
            this.tweetsCountInQueue();
        }, 1000);
    },

});

App.mixin(GlobalMixin);
App.component('tweet-form', TweetForm);
App.component('tweet-list', TweetList);
App.mount('#vue-app');
