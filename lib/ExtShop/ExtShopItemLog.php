<?php

class ExtShopItemLog {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        return $this->db->insert('ext_shop_item_log', $data);
    }

    public function read($conditions = [], $limit = 10) {
        return $this->db->select(['*'])
            ->from('ext_shop_item_log')
            ->where($conditions)
            ->limit($limit)
            ->get();
    }

    public function update($data, $conditions) {
        return $this->db->update('ext_shop_item_log', $data, $conditions);
    }

    public function delete($conditions) {
        return $this->db->delete('ext_shop_item_log', $conditions);
    }
    public function refreshExpiredLogs($memberId) {
        // 오늘 날짜
        $today = date('Ymd');

        // Active 상태인 로그를 가져옵니다.
        $activeLogs = $this->db->select(['*'])
            ->from('ext_shop_item_log')
            ->where([
                'member_id' => $memberId,
                'log_status' => 'A'
            ])
            ->get();

        foreach ($activeLogs as $log) {
            // 관련된 주문을 가져옵니다.
            $orders = $this->db->select(['item_use_days', 'item_option_full'])
                ->from('ext_shop_item_orders')
                ->where(['member_id' => $memberId, 'item_option_full' => $log['item_options']])
                ->get();

            // 사용 가능한 일수의 합을 계산합니다.
            $totalUseDays = 0;
            foreach ($orders as $order) {
                $totalUseDays += $order['item_use_days'];
            }

            // start_date와 totalUseDays를 비교하여 만료 체크
            $startDate = $log['start_date'];
            $expirationDate = date('Ymd', strtotime($startDate . " + $totalUseDays days"));

            // 오늘 날짜와 만료 날짜를 비교하여 남은 일수를 계산합니다.
            $today = new DateTime($today);
            $expirationDateObj = new DateTime($expirationDate);
            $interval = $today->diff($expirationDateObj);
            $remainDays = $interval->days; // 남은 일수

            if ($expirationDate < $today) {
                // 만료된 로그를 "End"로 업데이트
                $this->db->update('ext_shop_item_log', ['log_status' => 'E'], ['id' => $log['id']]);
                $newLogUUid =  uniqid();
                // 새로운 로그를 추가합니다.
                $newLogData = [
                    'uuid' => $newLogUUid, // 새로운 UUID 생성
                    'item_id' => $log['item_id'], // 기존 로그의 item_id 사용
                    'item_options' => $log['item_options'],
                    'member_id' => $memberId,
                    'start_date' => $today, // 오늘 날짜로 시작
                    'end_date' => null, // 종료일은 null로 설정
                    'log_status' => 'A',
                    'remain_download_days' => null, // 필요 시 설정
                    'remain_use_days' => null, // 필요 시 설정
                    'creater' => $log['creater']
                ];

                $rsInsert = $this->db->insert('ext_shop_item_log', $newLogData);
                // 결과 배열 구성
                $result = array(
                    'status' => $rsInsert,
                    'logUUid' => $newLogUUid, // UUID를 새로 생성한 로그에서 가져옵니다.
                    'remainDays' => ($expirationDate < $today->format('Ymd')) ? 0 : $remainDays // 만약 만료일이 오늘 이전이라면 0으로 설정
                );
            }
        }
        return $result;
    }
}
