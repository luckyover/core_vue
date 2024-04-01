IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M005_INQ2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M005_INQ2
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M005_INQ2 '0','','','','','50','1','delivery_cd','ASC','809','M005','172.19.0.1';
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Search list of deliverys
--*  
--*  作成日/create date			:	2024/02/26
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M005_INQ2
	@P_delivery_cd						NVARCHAR(5)		= N''
,	@P_delivery_nm						NVARCHAR(50)	= N''
,	@P_delivery_kn_nm					NVARCHAR(50)	= N''
,	@P_delivery_ab_nm					NVARCHAR(30)	= N''
,	@P_delivery_tel						NVARCHAR(20)	= N''
,	@P_page_size						INT				= 50
,	@P_page								INT				= 1
,	@P_sort_column						NVARCHAR(50)	= N'delivery_cd'
,	@P_sort_type						NVARCHAR(10)	= N'ASC'
,	@P_act_delivery_cd					NVARCHAR(10)	= N''
,	@P_prg								NVARCHAR(30)	= N''
,	@P_ip								NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
		@w_totalRecord					INT = 0
	,	@w_maxPage						INT = 0
	,	@w_offset						INT = 0
	,	@w_sql							NVARCHAR(MAX)

	CREATE TABLE #M005_TMP (
		delivery_cd						NVARCHAR(5)
	,	delivery_nm						NVARCHAR(50)
	,	delivery_kn_nm					NVARCHAR(50)
	,	delivery_ab_nm					NVARCHAR(30)
	,	delivery_zip					NVARCHAR(8)
	,	delivery_address1				NVARCHAR(50)
	,	delivery_address2				NVARCHAR(50)
	,	delivery_address3				NVARCHAR(100)
	,	delivery_tel					NVARCHAR(100)
	,	delivery_department_nm			NVARCHAR(100)
	,	delivery_manager_nm				NVARCHAR(100)
	,	delivery_mail_address			NVARCHAR(100)
	)

	INSERT INTO #M005_TMP
	SELECT
		M005.delivery_cd
	,   M005.delivery_nm
	,   M005.delivery_kn_nm
	,   M005.delivery_ab_nm
	,   M005.delivery_zip
	,   M005.delivery_address1
	,   M005.delivery_address2
	,   M005.delivery_address3
	,   M005.delivery_tel
	,   M005.delivery_department_nm
	,   M005.delivery_manager_nm
	,   M005.delivery_mail_address
	FROM M005 WITH(NOLOCK)
	WHERE (
		@P_delivery_cd						= 0
	OR	M005.delivery_cd					= @P_delivery_cd
	)
	AND (
		@P_delivery_nm						= N''
	OR	M005.delivery_nm					LIKE '%' + @P_delivery_nm + '%'
	)
	AND (
		@P_delivery_kn_nm					= N''
	OR	M005.delivery_kn_nm					LIKE '%' + @P_delivery_kn_nm + '%'
	)
	AND (
		@P_delivery_ab_nm					= N''
	OR	M005.delivery_ab_nm					LIKE '%' + @P_delivery_ab_nm + '%'
	)
	AND (
		@P_delivery_tel						= N''
	OR	M005.delivery_tel					LIKE '%' + @P_delivery_tel + '%'
	)
	AND M005.del_flg						<> 1

	SELECT @w_totalRecord = COUNT(delivery_cd) FROM #M005_TMP
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
		FROM #M005_TMP
		ORDER BY
		' +	ISNULL(NULLIF(@P_sort_column, ''), 'delivery_cd') + ' '  + ISNULL(NULLIF(@P_sort_type, ''), 'ASC') + '
		OFFSET ' + CONVERT(NVARCHAR, @w_offset) + '
		ROWS FETCH NEXT ' + CONVERT(NVARCHAR, @P_page_size) + ' ROWS ONLY'
	EXEC(@w_sql)

	SELECT
		@w_totalRecord		AS totalRecord
	,	@P_page				AS [page]
	,	@P_page_size		AS pageSize

	DROP TABLE IF EXISTS #M005_TMP
END
GO
