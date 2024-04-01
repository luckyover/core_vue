IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M004_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M004_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M004_INQ1 '2', '901', 'M004', '::1'
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get detail of customer
--*  
--*  作成日/create date			:	2024/02/19
--*　作成者/creater				:	HaiNN - ANS901
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE [dbo].[SPC_M004_INQ1]
	@P_customer_cd					INT				= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP 1
		M004.customer_cd
	,	M004.billing_source_cd
	,	M004.customer_nm
	,	M004.customer_kn_nm
	,	M004.customer_ab_nm
	,	M004.customer_zip
	,	M004.customer_address1
	,	M004.customer_address2
	,	M004.customer_address3
	,	M004.customer_tel
	,	M004.customer_fax
	,	M004.customer_department_nm
	,	M004.customer_manager_nm
	,	M004.customer_mail_address
	,	M004.customer_class_div1
	,	M004.customer_class_div2
	,	M004.customer_class_div3
	,	M004.billing_nm
	,	M004.billing_zip
	,	M004.billing_address1
	,	M004.billing_address2
	,	M004.billing_address3
	,	M004.billing_tel
	,	M004.billing_fax
	,	M004.billing_department_nm	
	,	M004.billing_manager_nm		
	,	M004.billing_mail_address	
	,	M004.billing_closing_div
	,	M004.transfer_date1
	,	M004.transfer_date2
	,	sales_employee.user_cd				AS sales_employee_cd
	,	sales_employee.user_nm				AS sales_employee_nm
	,	M004.price_list
	,	M004.reason_for_closure
	,	M004.remarks
	,	M004.cre_user_cd
	,	cre_user.user_nm					AS cre_user_nm
	,	FORMAT(M004.cre_tm, 'yyyy/MM/dd HH:mm')	AS cre_tm
	,	M004.upd_user_cd
	,	upd_user.user_nm					AS upd_user_nm
	,	FORMAT(M004.upd_tm, 'yyyy/MM/dd HH:mm')	AS upd_tm
	FROM M004 WITH(NOLOCK)
	LEFT JOIN M002		AS	cre_user	WITH(NOLOCK) ON (
		M004.cre_user_cd				= cre_user.user_cd
	)
	LEFT JOIN M002		AS	upd_user	WITH(NOLOCK) ON(
		M004.upd_user_cd				= upd_user.user_cd
	)
	LEFT JOIN M002		AS	sales_employee	WITH(NOLOCK) ON(
		M004.sales_employee_cd			= sales_employee.user_cd
	AND sales_employee.del_flg			<> 1
	)
	WHERE
		M004.customer_cd				= @P_customer_cd
	AND M004.del_flg					<> 1
END
