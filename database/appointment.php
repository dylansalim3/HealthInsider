<?php

require_once "database.php";

class appointment
{
    private $database;
    private $limit = 5;

    public function __construct()
    {
        $this->database = new database();
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function numbers(): ?array
    {
        $count = array();
        //            pending
        $statement = $this->database->prepare("
            select count(*) from appointment
            where STATUS = 2
        ");
        $statement->execute();
        $count['pending'] = $statement->get_result()->fetch_row()[0];
        //        upcoming
        $statement = $this->database->prepare("
            select count(*) from appointment
            where STATUS = 1 and DATE >= current_date()
        ");
        $statement->execute();
        $count['upcoming'] = $statement->get_result()->fetch_row()[0];
        //            history
        $statement = $this->database->prepare("
            select count(*) from appointment
        ");
        $statement->execute();
        $count['history'] = $statement->get_result()->fetch_row()[0];
        //        slot
        $statement = $this->database->prepare("
            select count(*) from doctor_slot
            where STATUS = 1 and DOCTOR_DAY >= CURDATE()
        ");
        $statement->execute();
        $count['availability'] = $statement->get_result()->fetch_row()[0];

        return $count;
    }

    public function todayList()
    {
        $statement = $this->database->prepare("
            select PATIENT_ID,DOCTOR_ID,DATE,TIME from appointment 
            where date = current_date()
            order by TIME
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function pending(int $offset = 0): ?array
    {
        $statement = $this->database->prepare("
            select * from appointment
            inner join doctor_slot d1
            on (d1.DOCTOR_DAY = appointment.DATE) AND
            (d1.DOCTOR_TIME = APPOINTMENT.TIME) AND
            (d1.DOCTOR_ID = APPOINTMENT.DOCTOR_ID)
            where appointment.STATUS = 2 
            order by DATE
            limit {$offset}, {$this->limit}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function upcoming(int $offset = 0): ?array
    {
        $statement = $this->database->prepare("
            select * from appointment
            where STATUS = 1 and DATE >= current_date()
            order by date 
            limit {$offset}, {$this->limit}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function history(int $offset = 0): ?array
    {
        $statement = $this->database->prepare("
            select * from (
                select * from appointment
                order by date desc 
                limit {$offset}, {$this->limit}
            ) as a 
            order by DATE 
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getDoctorSlot(int $offset = 0): ?array
    {
        $statement = $this->database->prepare("
            select * from doctor_slot
            where STATUS = 1 AND DOCTOR_DAY >= CURDATE()
            limit {$offset}, {$this->limit}
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addDoctorSlot($id, $date, $time)
    {
        $statement = $this->database->prepare("
            insert into doctor_slot (DOCTOR_ID, DOCTOR_DAY, DOCTOR_TIME, STATUS) 
            values ({$id}, '{$date}', '{$time}', 1)
        ");
        $statement->execute();
    }

    public function getDoctor($special, $date, $time): ?array
    {
        $statement = $this->database->prepare("
            select * 
            from doctor_slot s inner join doctor d 
                on s.DOCTOR_ID = d.DOCTOR_ID
            where STATUS = 1 and SPECIALIZATION = '{$special}' and s.DOCTOR_DAY = '{$date}' and s.DOCTOR_TIME = '{$time}'
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function accept(int $appointmentId, int $slotId)
    {
        $statement = $this->database->prepare("
            update appointment
            set STATUS = 1, DOCTOR_ID = (
                select doctor_slot.DOCTOR_ID 
                from doctor_slot 
                where DOCTOR_SLOT_ID = {$slotId}
            )
            where APPOINTMENT_ID = {$appointmentId}
        ");
        $statement->execute();

        $statement = $this->database->prepare("
            update doctor_slot
            set STATUS = 0
            where DOCTOR_SLOT_ID = {$slotId}
        ");
        $statement->execute();
    }

    public function reject(int $appointmentId)
    {
        $statement = $this->database->prepare("
            update appointment
            set STATUS = 0
            where APPOINTMENT_ID = {$appointmentId} 
        ");
        $statement->execute();
    }

    public function rejectReason(int $appointmentId, string $reason)
    {
        $statement = $this->database->prepare("
            update appointment
            set REJECT_REASON = ?
            where APPOINTMENT_ID = {$appointmentId} 
        ");
        $statement->bind_param('s', $reason);
        $statement->execute();
    }

    public function getEvents()
    {
        $statement = $this->database->prepare("
            select a.DATE, a.TIME, p.PATIENT_NAME, a.DOCTOR_ID
            from patient p inner join appointment a
            on p.PATIENT_ID = a.PATIENT_ID where STATUS = 1
        ");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
