IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M002_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M002_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M002_INQ1 '809', '809', 'M002', '::1'
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get detail of user
--*  
--*  作成日/create date			:	2024/02/17
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M002_INQ1
	@P_user_cd						NVARCHAR(50)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP 1
		M002.user_cd
	,	M002.[password]
	,	M002.user_nm
	,	M002.user_kn_nm
	,	M002.user_ab_nm
	,	M002.tel
	,	M002.fax
	,	M002.mailaddress
	,	M002.belong_department_div
	,	M002.authority_div
	,	M002.remarks
	,	M002.cre_user_cd
	,	cre_user.user_nm						AS cre_user_nm
	,	FORMAT(M002.cre_tm, 'yyyy/MM/dd HH:mm')	AS cre_tm
	,	M002.upd_user_cd
	,	upd_user.user_nm						AS upd_user_nm
	,	FORMAT(M002.upd_tm, 'yyyy/MM/dd HH:mm')	AS upd_tm
	FROM M002 WITH(NOLOCK)
	LEFT JOIN M002		AS	cre_user WITH(NOLOCK)	ON (
		M002.cre_user_cd				= cre_user.user_cd
	)
	LEFT JOIN M002		AS	upd_user WITH(NOLOCK)	ON (
		M002.upd_user_cd				= upd_user.user_cd
	)
	WHERE
		M002.user_cd					= @P_user_cd
	AND M002.del_flg					<> 1
END
GO
