<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Message queue service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const API_URL = '/redis-message-queue-service';
    </script>
</head>
<body>
<div id="vue-app" class="wrapper">

        <nav class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                    <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                            <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg">
                            <h2 style="color:white; font-size: 22px; font-weight: bold; margin-left: 20px;">Сервис сообщений</h2>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="bg-white">
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div style="margin: 10px 0px 10px 0px !important; border-bottom: 1px gainsboro solid; padding-bottom: 4px;">
                    Количество сообщений в очереди : {{countInQueue}}
                </div>
                <section aria-labelledby="products-heading" class="pt-6 pb-24">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-8 gap-y-10">
                        <tweet-list/>
                    </div>
                </section>
            </main>
        </div>

</div>
</body>

<script src="resource/components.js" type="application/javascript"></script>
<script src="resource/app.js" type="application/javascript"></script>

</html>





