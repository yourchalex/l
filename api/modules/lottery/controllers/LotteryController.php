<?php

namespace api\modules\lottery\controllers;

use yii\db\Expression;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class LotteryController extends Controller
{
    /**
     *    SELECT
     *   `l`.`entry_price`                       AS `entry_price`,
     *   `ld`.`player_uuid`                      AS `playerUUID`,
     *   `lp`.`username`                         AS `userName`,
     *   SUM(ld.amount)                          AS `sumAmount`,
     *   `ltp`.`currency`                        AS `userCurrency`,
     *   `ltp`.`coefficient`                     AS `coefficient`,
     *   ROUND(SUM(ld.amount) / ltp.coefficient) AS `ticketCount`
     *   FROM `lottery` `l` INNER JOIN `lottery_ticket_price` `ltp` ON l.id = ltp.lottery_id
     *   INNER JOIN `lottery_deposit` `ld` ON ld.currency = ltp.currency
     *   INNER JOIN `lottery_profile` `lp` ON lp.player_uuid = ld.player_uuid
     *   WHERE
     *   ((`l`.`id` = :qp0) AND (`lp`.`currency` = ltp.currency)) AND (`ld`.`processed_at` BETWEEN l.start_date AND l.end_date)
     *   GROUP BY `playerUUID`, `ltp`.`coefficient`
     *   HAVING entry_price < ticketCount
     *
     * @param int $lotteryId
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGetParticipants(int $lotteryId): array
    {
        $participants = $this->_getLotteryParticipants($lotteryId);
        if (!$participants) {
            throw new NotFoundHttpException('Lottery participants not found');
        }

        return [
            'content' => $participants
        ];
    }

    /**
     *    SELECT
     *   `l`.`entry_price`                       AS `entry_price`,
     *   `ld`.`player_uuid`                      AS `playerUUID`,
     *   `lp`.`username`                         AS `userName`,
     *   SUM(ld.amount)                          AS `sumAmount`,
     *   `ltp`.`currency`                        AS `userCurrency`,
     *   `ltp`.`coefficient`                     AS `coefficient`,
     *   ROUND(SUM(ld.amount) / ltp.coefficient) AS `ticketCount`
     *   FROM `lottery` `l` INNER JOIN `lottery_ticket_price` `ltp` ON l.id = ltp.lottery_id
     *   INNER JOIN `lottery_deposit` `ld` ON ld.currency = ltp.currency
     *   INNER JOIN `lottery_profile` `lp` ON lp.player_uuid = ld.player_uuid
     *   WHERE ((`l`.`id` = :qp0) AND (`lp`.`currency` = ltp.currency)) AND (`ld`.`player_uuid` = :qp1) AND
     *   (`ld`.`processed_at` BETWEEN l.start_date AND l.end_date)
     *   GROUP BY `playerUUID`, `ltp`.`coefficient`
     *   HAVING entry_price < ticketCount
     *
     * @param int $lotteryId
     * @param int $playerUUID
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGetParticipantById(int $lotteryId, int $playerUUID): array
    {
        $participant = $this->_getLotteryParticipants($lotteryId, $playerUUID);
        if (!$participant) {
            throw new NotFoundHttpException('Lottery participant not found');
        }

        return current($participant);
    }

    /**
     * @param int $lotteryId
     * @param int|null $playerUUID
     * @return array
     * @throws NotFoundHttpException
     */
    private function _getLotteryParticipants(int $lotteryId, int $playerUUID = null): array
    {
        return (new \yii\db\Query())
            ->select([
                'rank' => 'l.entry_price',
                'playerUUID' => 'ld.player_uuid',
                'userName' => 'lp.username',
                'sumAmount' => new Expression('SUM(ld.amount)'),
                'userCurrency' => 'ltp.currency',
                'ticketCount' => new Expression('ROUND(SUM(ld.amount)/ltp.coefficient)'),
            ])
            ->from('lottery l')
            ->where([
                'l.id' => $lotteryId,
                'lp.currency' => new Expression('ltp.currency')
            ])
            ->andFilterWhere(['ld.player_uuid' => $playerUUID])
            ->andWhere([
                'between',
                'ld.processed_at',
                new Expression('l.start_date'),
                new Expression('l.end_date'),
            ])
            ->innerJoin('lottery_ticket_price ltp', 'l.id = ltp.lottery_id')
            ->innerJoin('lottery_deposit ld', 'ld.currency = ltp.currency')
            ->innerJoin('lottery_profile lp', 'lp.player_uuid = ld.player_uuid')
            ->groupBy(['playerUUID', 'ltp.coefficient'])
            ->having('rank < ticketCount')
            ->all();
    }
}