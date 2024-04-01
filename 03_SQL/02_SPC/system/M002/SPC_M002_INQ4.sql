IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M002_INQ4]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M002_INQ4
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M002_INQ4 
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Search list of users
--*  
--*  作成日/create date			:	2024/02/26
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M002_INQ4
	@P_user_cd						NVARCHAR(5)		= N''
,	@P_user_nm						NVARCHAR(50)	= N''
,	@P_user_kn_nm					NVARCHAR(50)	= N''
,	@P_user_ab_nm					NVARCHAR(30)	= N''
,	@P_tel							NVARCHAR(20)	= N''
,	@P_fax							NVARCHAR(20)	= N''
,	@P_mailaddress					NVARCHAR(255)	= N''
,	@P_belong_department_div		INT				= 0
,	@P_page_size					INT				= 50
,	@P_page							INT				= 1
,	@P_sort_column					NVARCHAR(50)	= N'user_cd'
,	@P_sort_type					NVARCHAR(10)	= N'ASC'
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
		@w_totalRecord				INT = 0
	,	@w_maxPage					INT = 0
	,	@w_offset					INT = 0
	,	@w_sql						NVARCHAR(MAX)

	CREATE TABLE #M002_TMP (
		user_cd						NVARCHAR(5)
	,	user_nm						NVARCHAR(50)
	,	user_kn_nm					NVARCHAR(50)
	,	user_ab_nm					NVARCHAR(30)
	,	tel							NVARCHAR(20)
	,	fax							NVARCHAR(20)
	,	mailaddress					NVARCHAR(225)
	,	belong_department_div_nm	NVARCHAR(50)
	)

	INSERT INTO #M002_TMP
	SELECT
		M002.user_cd
	,   M002.user_nm
	,   M002.user_kn_nm
	,   M002.user_ab_nm
	,   M002.tel
	,   M002.fax
	,   M002.mailaddress
	,   belong_department_div.[name]
	FROM M002 WITH(NOLOCK)
	LEFT JOIN M401						AS belong_department_div WITH(NOLOCK) ON (
		M002.belong_department_div		= belong_department_div.name_cd
	AND belong_department_div.name_div	= 'belong_department_div'
	)
	WHERE (
		@P_user_cd						= N''
	OR	M002.user_cd					= @P_user_cd
	)
	AND (
		@P_user_nm						= N''
	OR	M002.user_nm					LIKE '%' + @P_user_nm + '%'
	)
	AND (
		@P_user_kn_nm					= N''
	OR	M002.user_kn_nm					LIKE '%' + @P_user_kn_nm + '%'
	)
	AND (
		@P_user_ab_nm					= N''
	OR	M002.user_ab_nm					LIKE '%' + @P_user_ab_nm + '%'
	)
	AND (
		@P_tel							= N''
	OR	M002.tel						LIKE '%' + @P_tel + '%'
	)
	AND (
		@P_fax							= N''
	OR	M002.fax						LIKE '%' + @P_fax + '%'
	)
	AND (
		@P_mailaddress					= N''
	OR	M002.mailaddress				LIKE '%' + @P_mailaddress + '%'
	)
	AND (
		@P_belong_department_div		= 0
	OR	M002.belong_department_div		= @P_belong_department_div
	)
	AND M002.del_flg					<> 1

	SELECT @w_totalRecord = COUNT(user_cd) FROM #M002_TMP
	SET @w_maxPage = @w_totalRecord / @P_page_size + IIF(@w_totalRecord % @P_page_size > 0, 1, 0)
	IF @P_page > @w_maxPage
	BEGIN
		SET @P_page = @w_maxPage
	END
	IF @P_page < 1
	BEGIN
		SET @P_page = 1
	END
	SET @w_offset = (@P_page - 1) * @P_page_size

	SET @w_sql = 
		'SELECT
			*
		FROM #M002_TMP
		ORDER BY
		' +	ISNULL(NULLIF(@P_sort_column, ''), 'user_cd') + ' '  + ISNULL(NULLIF(@P_sort_type, ''), 'ASC') + '
		OFFSET ' + CONVERT(NVARCHAR, @w_offset) + '
		ROWS FETCH NEXT ' + CONVERT(NVARCHAR, @P_page_size) + ' ROWS ONLY'
	EXEC(@w_sql)

	SELECT
		@w_totalRecord		AS totalRecord
	,	@P_page				AS [page]
	,	@P_page_size		AS pageSize

	DROP TABLE IF EXISTS #M002_TMP
END
GO
