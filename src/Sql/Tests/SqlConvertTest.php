<?php
use PHPUnit\Framework\TestCase;
use Ydin\Sql\Convert as SqlConvert;

final class SqlConvertTest extends TestCase
{
    /**
     *
     */
    public function test_sql_convert()
    {
        $sql = <<<EOD
        select
            attempts.day as day
            , attempts.processor_id, attempts.card_type, attempts.subscription_plan
            , attempts.attempt_count
            , table1.authorization_success_count
            , table2.activation_success_count
            , renewal01.renewal_success_count_01
            , renewal01.renewal_revenue_01
            , renewal02.renewal_success_count_02
            , renewal02.renewal_revenue_02
        
        from (
            select
                date(attempt_at) as day,
                processor_id, card_type, subscription_plan,
                count(*) as attempt_count
            from search_bi_attempts
            where attempt_at between :startTime and :endTime
            group by day, processor_id, card_type, subscription_plan
        )
        AS attempts
        
        left join (
            select
                date(trial_started_at) as myday,
                processor_id, card_type, subscription_plan,
                count(*) as authorization_success_count
            from search_bi_subscriptions
            where trial_started_at between :startTime and :endTime
            group by myday, processor_id, card_type, subscription_plan
        )
        AS table1
        ON table1.processor_id = attempts.processor_id AND table1.card_type = attempts.card_type AND table1.subscription_plan = attempts.subscription_plan

        left join (
            select
                date(trial_started_at) as myday,
                s.processor_id, s.card_type, s.subscription_plan,
                count(distinct s.subscription_id) as activation_success_count
                from search_bi_subscriptions s
                    join search_bi_subscription_payments p
                    on s.subscription_id = p.subscription_id
            where trial_started_at between :startTime and :endTime
            group by myday, s.processor_id, s.card_type, s.subscription_plan
        )
        AS table2
        ON table2.processor_id = attempts.processor_id AND table2.card_type = attempts.card_type AND table2.subscription_plan = attempts.subscription_plan

EOD;


        $sqlValidate = <<<EOD
        select
            attempts.day as day
            , attempts.processor_id, attempts.card_type, attempts.subscription_plan
            , attempts.attempt_count
            , table1.authorization_success_count
            , table2.activation_success_count
            , renewal01.renewal_success_count_01
            , renewal01.renewal_revenue_01
            , renewal02.renewal_success_count_02
            , renewal02.renewal_revenue_02
        
        from (
            select
                date(attempt_at) as day,
                processor_id, card_type, subscription_plan,
                count(*) as attempt_count
            from search_bi_attempts
            where attempt_at between ? and ?
            group by day, processor_id, card_type, subscription_plan
        )
        AS attempts
        
        left join (
            select
                date(trial_started_at) as myday,
                processor_id, card_type, subscription_plan,
                count(*) as authorization_success_count
            from search_bi_subscriptions
            where trial_started_at between ? and ?
            group by myday, processor_id, card_type, subscription_plan
        )
        AS table1
        ON table1.processor_id = attempts.processor_id AND table1.card_type = attempts.card_type AND table1.subscription_plan = attempts.subscription_plan

        left join (
            select
                date(trial_started_at) as myday,
                s.processor_id, s.card_type, s.subscription_plan,
                count(distinct s.subscription_id) as activation_success_count
                from search_bi_subscriptions s
                    join search_bi_subscription_payments p
                    on s.subscription_id = p.subscription_id
            where trial_started_at between ? and ?
            group by myday, s.processor_id, s.card_type, s.subscription_plan
        )
        AS table2
        ON table2.processor_id = attempts.processor_id AND table2.card_type = attempts.card_type AND table2.subscription_plan = attempts.subscription_plan

EOD;

        $bindings = [
            "startTime" => "2019-07-01",
            "endTime"   => "2019-07-31",
        ];

        $bindingsValidate = [
            "2019-07-01",
            "2019-07-31",
            "2019-07-01",
            "2019-07-31",
            "2019-07-01",
            "2019-07-31",
        ];

        list($sqlConvert, $bindingsConvert) = SqlConvert::convertPreparedStatementAboutAttribEmulation($sql, $bindings);
        $this->assertEquals($sqlConvert, $sqlValidate);
        $this->assertEquals($bindingsConvert, $bindingsValidate);
    }

}
