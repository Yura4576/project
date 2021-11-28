<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCatalogMainJob extends AbstractJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     *
     */
    public function handle()
    {
        $this->debug('start');

        // Сначала кешируем продукты
        GenerateCatalogCacheJob::dispatchNow();

        //Затем создаем цепочку заданий формирования файлов с ценами
        $chainPrices = $this->getChainPrices();

        //Основыне подзадачи
        $chainMain = [
            new GenerateCategoriesJob(),    //Генерация категорий
            new GenerateDeliveriesJob,      //Генерация способов доставок
            new GeneratePointsJob(),        //Генерация пунктов выдачи
        ];

        //Подзадачи которые должны выполнится самыми последними
        $chainLast = [
            //Архивирование файлов и перенос архива в публичную папку
            new ArchiveUpLoadsJob,
            //Отправка уведомления сторонниму сервису о том что можно скачать новый файл каталога товаров
            new SendPriceRequestJob,
        ];

        $chain = array_merge($chainPrices, $chainMain, $chainLast);

        GenerateGoodsFileJob::withChain($chain)->dispatch();
        //GenerateGoodsFileJob::dispatch()->chain($chain);

        $this->debug('finish');
    }

    /**
     * Формирование цепочек подзадач по генерации файлов с ценами
     *
     * @return array
     */
    private function getChainPrices()
    {
        $result = [];
        $products = collect([1,2,3,4,5]);
        $fileNum = 1;

        foreach ($products->chunk(1) as $chunk){
            $result = new GeneratePricesFileChunkJob($chunk,$fileNum);
            $fileNum++;
        }

        return $result;
    }
}
