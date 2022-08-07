
const TweetForm = {

    data() {
        return {
            redisTweets : [],
            tweetForm  : {
                category_id: 0,
                username: '',
                content : '',
            }
        }
    },

    methods: {
        addTweet() {

            const url = '/src/producer.php?action=add-tweet';
            this.post(url, this.tweetForm, (response) => {
                this.redisTweets = response;

                this.tweetForm.category_id = 0;
                this.tweetForm.username = '';
                this.tweetForm.content  = '';

                alert('Сообщение добавлено в очередь');

                this.$emit('add_tweet', {status : 1});
            });
        },
    },

    template: `
    <div class="mt-10 sm:mt-0" style="width:100%; margin: 4px 0px 5px 0px" >

            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-10">
                
                        <div style="display: flex;" >
                        
                            <div style="border:0px red solid; padding:5px; width: 50%" >
                                <label for="email-address" class="block text-sm font-medium text-gray-700">Ваше имя</label>
                                <input type="text"  v-model="tweetForm.username" style="height: 40px; border:1px gainsboro solid;"
                                      class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div style="border:0px red solid; padding:5px; width: 100%" >
                                <label for="country" class="block text-sm font-medium text-gray-700">Категория</label>
                                <select  v-model="tweetForm.category_id"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option v-for="(elem) in categoryList" :value="elem.id">{{elem.title}}</option>
                                </select>
                            </div>
                        
                        </div>

                        <div style="display: flex;">
                            <div style="margin-top: 15px; width: 80%">
                                <label for="street-address" class="block text-sm font-medium text-gray-700">Сообщение</label>
                                <textarea  rows="4"  v-model="tweetForm.content"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" ></textarea>
                            </div>
                            
                            <div style="width:18%; margin: 15px 0px 0px 10px; padding-top: 25px; ">
                                <button @click="addTweet()"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                   > Отправить сообщение </button>
                            </div>
                            
                        </div>
                        
                </div>

            </div>
    </div>`
}

const TweetList = {

    methods: {

        addTweetResponse() {
            this.getTweets();
            setTimeout(() => {
                this.getTweets();
            }, 1000);
        },

    },

    template: `

        <!-- ЛЕВАЯ ПАНЕЛЬ -->
        <div class="hidden lg:block">
           <ul role="list"
                class="text-sm font-medium text-gray-900 space-y-4 pb-6 border-b border-gray-200">
                <li @click="selectTweets({ id: 0, title: 'Все категории'})"><a href="#"> Все категории </a></li>
                <li v-for="(elem) in categoryList" 
                    @click="selectTweets(elem)"><a href="#"> {{elem.title}}</a></li>
           </ul> 
        </div>

        <!-- ПРАВАЯ ПАНЕЛЬ -->
        <div class="lg:col-span-3">

            <tweet-form @add_tweet="addTweetResponse"/>
            
             <h2 style="font-weight: bold; font-size: 19px">{{categoryName}}</h2> 
            
            <div class="border-1 border-solid border-gray-200  h-96 lg:h-full"
               style="border: 1px gainsboro solid; padding:10px">

               <dl class="mt-5 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-1 sm:gap-y-16 lg:gap-x-8">
                   <template v-for="(item) in tweets">
                        <div class="border-t border-gray-200 pt-4" style="width: 100%">
                          <dt class="font-medium text-gray-900">{{item.cat_title}}</dt>
                          <dd class="mt-2 text-sm text-gray-500">{{item.content}}</dd>
                          
                          <div style="display: flex">
                             <dd class="mt-2 text-sm text-gray-500">Автор: {{item.username}}</dd>
                             <dd class="mt-2 text-sm text-gray-500" 
                                 style="margin-left: 20px; font-style: italic">{{item.created_at}}</dd>
                          </div>
                          
                        </div>
                   </template>  
                </dl> 
               
            </div>
        </div> 
    `
}