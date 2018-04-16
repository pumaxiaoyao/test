<?php

namespace App\Controllers;

class PlatformType
{
    const MAIN = 1;
    const IBC = 2;
}

class CheckStatus
{
    const wait = 1;
    const agree = 2;
    const refuse = 4;
}

class BankCardStatus
{
    const available = 1;
    const unavailable = 2;
	const delete = 3;
}

class MessageStatus
{
    const new = 1;
    const read = 2;
    const delete = 3;
}

class ActivityStatus
{
    const open = 1;
    const close = 2;
    const delete = 3;
}

class PayStatus
{
    const valid = 1;
    const invalid = 2;
    const delete = 3;
}

class PayPosType
{
    const web = 1;
    const phone = 2;
    const app = 4;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//玩家
class PlayerStatus
{
    //待审核
    const check = 1;
    //正常
    const ok = 2;
    //锁定
    const lock = 3;
    //审核失败
    const checkFail = 4;
}

class PlayerRecordLoginType
{
    const login = 1;
	const logout = 2;
}

class PlayerRecordBalanceType
{
    //存款
    const deposit = 1;
	//取款
	const withdrawal = 2;
	//转入
	const transactIn = 4;
	//转出
	const transactOut = 8;
	//返水
	const rebate = 16;
	//红利
	const bonus = 32;
	//存款优惠
	const depositBonus = 64;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//代理

class AgentStatus
{
    //待审核
    const check = 1;
	//正常
	const ok = 2;
	//锁定
	const lock = 3;
	//审核失败
	const checkFail = 4;
}

class JointType
{
    const a = 1;
    const b = 2;
}

class RateType
{
    const no = 0;
	const fix = 1;
	const flow = 2;
}

class SettleStatementStatus
{
    const wait = 1;
	const check = 2;
	const agree = 4;
}

class AgentRecordBalanceType
{
    const withdrawal = 1;
	const commision = 2;
}
